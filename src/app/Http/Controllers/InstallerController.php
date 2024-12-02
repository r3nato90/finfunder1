<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Rules\DatabaseConnectionRule;
use App\Services\FinfunderService;
use App\Utilities\Installer\EnvironmentHelper;
use App\Utilities\Installer\PermissionsChecker;
use App\Utilities\Installer\RequirementsChecker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class InstallerController extends Controller
{
    public function __construct(
        protected RequirementsChecker $requirementsChecker,
        protected PermissionsChecker $permissionsChecker,
        protected EnvironmentHelper $environmentHelper,
        protected FinfunderService $finfunderService,
    ){

    }
    protected function installed(): bool
    {
        return file_exists(storage_path('installed'));
    }

    public function index(): View|RedirectResponse
    {
        if ($this->installed()) {
            return redirect()->route('home');
        }

        Artisan::call('optimize:clear');

        $setTitle = config('installer.name');
        $requirements = $this->requirementsChecker->check(config('installer.requirements'));
        $checkPhpVersion = $this->requirementsChecker->checkPhpVersion();

        return view('installer.requirements', compact('setTitle', 'requirements', 'checkPhpVersion'));
    }

    public function permissions(): View|RedirectResponse
    {
        if ($this->installed()) {
            return redirect()->route('home');
        }

        try {
            $requirements = $this->requirementsChecker->check(config('installer.requirements'));
            $errorFlag = false;

            foreach (@$requirements as $requirement) {
                foreach ($requirement ?? [] as $permission) {
                    foreach ($permission ?? [] as $error) {
                        if (!$error) {
                            $errorFlag = true;
                        }
                    }
                }
            }

            if ($errorFlag) {
                return back()->with('notify', [['error', 'Please fulfill all server requirements before proceeding to the next step']]);
            }

            $checkPhpVersion = $this->requirementsChecker->checkPhpVersion();
            if (!$checkPhpVersion['supported']) {
                return back()->with('notify', [['error', 'Please fulfill all server requirements before proceeding to the next step']]);
            }

            $setTitle = config('installer.name');
            $permissions = Arr::get($this->permissionsChecker->check(config('installer.permissions')), 'permissions', []);

            return view('installer.permissions', compact('setTitle', 'permissions'));
        } catch (\Exception $e) {
            return back()->with('notify',[['error' => $e->getMessage()]]);
        }
    }

    public function environment(): View|RedirectResponse
    {
        if ($this->installed()) {
            return redirect()->route('home');
        }

        try {
            $permissions = Arr::get($this->permissionsChecker->check(config('installer.permissions')), 'permissions', []);
            foreach ($permissions as $permission) {
                if (!$permission['isSet']){
                    return back()->with('notify', [['error', 'Please check permissions before proceeding to the next step']]);
                }
            }

            $setTitle = config('installer.name');
            $environment = [];
            foreach (config('installer.environment.form') as $envKey => $config) {
                Arr::set($environment, 'environments.'.$envKey, config($config['config_key']));
            }

            $environment = Arr::get($environment, 'environments', []);
            return view('installer.environment', compact('setTitle', 'environment'));
        } catch (\Exception $e) {
            return back()->with('notify',[['error', $e->getMessage()]]);
        }
    }

    public function environmentSave(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'environments.app.name' => ['required'],
                'environments.envato.purchase_code' => ['required'],
                'environments.app.url' => ['required'],
                'environments.database.host' => ['required', 'string', new DatabaseConnectionRule()],
                'environments.database.port' => ['required', 'string', new DatabaseConnectionRule()],
                'environments.database.name' => ['required', 'string', new DatabaseConnectionRule()],
                'environments.database.username' => ['required', 'string', new DatabaseConnectionRule()],
                'environments.database.password' => ['nullable', 'string', new DatabaseConnectionRule()],
            ]);

            $data = $this->finfunderService->callApi('post','license-activate', [
                "purchase_code" => $request->input('environments.envato.purchase_code'),
            ]);

            if (is_array($data) && array_key_exists('error', $data)){
                $error = Arr::get($data, 'error', 'Invalid purchase code');
                return back()->with('notify', [['error',$error]]);
            }

            $this->environmentHelper->updateAllEnv(config('installer.environment.form'), $request->input('environments'));

            return redirect()->route('installer.application', ['key' => base64_encode('database-setup')]);
        } catch (\Exception $e) {
            return back()->with('notify',[['error', $e->getMessage()]]);
        }
    }


    public function application(string $key): View|RedirectResponse
    {
        if ($this->installed()) {
            return redirect()->route('home');
        }

        try {
            if (base64_decode($key) != 'database-setup') {
                return back()->with('notify', [['error', 'Please fill in the database information before proceeding to the next step']]);
            }

            $setTitle = config('installer.name');
            return view('installer.application', compact('setTitle'));
        } catch (\Exception $e) {
            return back()->with('notify',[['error', $e->getMessage()]]);
        }
    }


    public function run(Request $request): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'username' => 'required',
                'email' => 'required|string|email|max:255',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return back()->with('notify', [['error', "Something went wrong. Please verify your connection details and try again"]]);
            }

            Artisan::call('migrate:fresh', [
                '--force' => true,
            ]);

            Admin::create([
                'name'     => $request->input('name'),
                'username' => $request->input('username'),
                'email'    => $request->input('email'),
                'password'   => Hash::make($request->input('password')),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Artisan::call('db:seed', [
                '--force' => true,
            ]);

            file_put_contents(storage_path('installed'), 'installed');
            return redirect()->route('installer.success', ['key' => base64_encode('installer-success')]);

        } catch (\Exception $exception) {
            return back()->with('notify', [['error', "Something went wrong. Please verify your connection details and try again"]]);
        }
    }
    public function success(string $key): View|RedirectResponse
    {
        if (base64_decode($key) != 'installer-success') {
            return back()->with('notify', [['error', 'Please fill in the admin information before proceeding to the next step']]);
        }
        Artisan::call('optimize:clear');
        $setTitle = config('installer.name');
        return view('installer.success', compact('setTitle'));
    }
}
