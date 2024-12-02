<?php

namespace App\Http\Controllers\Admin;

use App\Concerns\UploadedFile;
use App\Enums\GeneralSetting;
use App\Enums\Payment\GatewayCode;
use App\Enums\Payment\GatewayName;
use App\Enums\Payment\GatewayStatus;
use App\Enums\Payment\GatewayType;
use App\Enums\RoleEnum;
use App\Enums\Status;
use App\Enums\Theme\ThemeName;
use App\Http\Controllers\Controller;
use App\Models\BlockIp;
use App\Models\Contributor;
use App\Models\Cron;
use App\Models\FirewallLog;
use App\Models\PaymentGateway;
use App\Models\User;
use App\Services\SettingService;
use App\Utilities\Installer\EnvironmentHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\GeneralSettingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    use UploadedFile;

    public function __construct(
        protected EnvironmentHelper $environmentHelper,
    ){

    }
    /**
     * @return View
     */
    public function index(): View
    {
        $setTitle = __('admin.setting.page_title.index');

        return view('admin.setting.index', compact('setTitle'));
    }

    /**
     * @return View
     */
    public function general(): View
    {
        $setTitle = __('admin.setting.page_title.general');
        $timeLocations = timezone_identifiers_list();

        return view('admin.setting.general', compact('setTitle', 'timeLocations'));
    }

    /**
     * @return View
     */
    public function configuration(): View
    {
        $setTitle = __('admin.setting.page_title.configuration');

        return view('admin.setting.configuration', compact('setTitle'));
    }

    /**
     * @return View
     */
    public function commissions(): View
    {
        $setTitle = __('admin.setting.page_title.commission');

        return view('admin.setting.commissions_charge', compact('setTitle'));
    }


    /**
     * @return View
     */
    public function kyc(): View
    {
        $setTitle = __('admin.setting.page_title.kyc');

        return view('admin.setting.kyc', compact('setTitle'));
    }


    /**
     * @return View
     */
    public function system(): View
    {
        $setTitle = __('admin.setting.page_title.system');

        $server_detail = $_SERVER;
        $applicationInfo = include (resource_path("data/application_info.php"));
        return view('admin.setting.system', compact('setTitle', 'server_detail', 'applicationInfo'));
    }


    /**
     * @return View
     */
    public function automation(): View
    {
        $setTitle = __('admin.setting.page_title.automation');
        $cron = Cron::paginate(getPaginate());

        return view('admin.setting.automation', compact('setTitle', 'cron'));
    }

    /**
     * @return View
     */
    public function application(): View
    {
        $setTitle = __('admin.setting.page_title.application');

        return view('admin.setting.application_update', compact('setTitle'));
    }


    /**
     * @param GeneralSettingRequest $request
     * @return mixed
     */
    public function update(GeneralSettingRequest $request): RedirectResponse
    {
        $type = $request->input('type');
        $setting = SettingService::getSetting();

        if($type == GeneralSetting::SEO_SETTING->value){
            $seoSetting = $request->input('seo_setting');
            if ($request->hasFile('seo_setting.image')) {
                $imagePath = $this->move($request->file('seo_setting.image'));
                Arr::set($seoSetting, 'image', $imagePath);
            } else {
                $defaultImagePath = Arr::get($setting->seo_setting, 'image');
                Arr::set($seoSetting, 'image', $defaultImagePath);
            }

            $setting->seo_setting = $seoSetting;

        }elseif($type == GeneralSetting::THEME_SETTING->value){
            $setting->theme_setting = Arr::map($request->input($type), function ($value) {
                if (!Str::startsWith($value, "#")) {
                    return '#' . $value;
                }
                return $value;
            });
        }elseif ($type == GeneralSetting::SYSTEM_CONFIGURATION->value){
            $newArray = $setting->system_configuration;
            foreach ($newArray as $key => $value){
                if(!array_key_exists($key, $request->input($type, []))){
                    Arr::set($newArray, $key.'.value', Status::INACTIVE->value);
                }else{
                    Arr::set($newArray, $key.'.value', Status::ACTIVE->value);
                }
            }
            $setting->system_configuration = $newArray;
        }else{
            $setting->$type = $request->input($type);
        }

        $setting->save();

        if($type == GeneralSetting::APPEARANCE->value){
            $timezoneFile = config_path('timezone.php');
            $timezoneValue = var_export($request->input('appearance.timezone'), true);
            $content = '<?php $timezone = ' . $timezoneValue . '; ?>';
            file_put_contents($timezoneFile, $content);
        }

        return back()->with('notify', [['success', 'Basic setting has been updated']]);
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updateLogo(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'dark' => 'nullable|image|mimes:jpg,png,jpeg',
            'white' => 'nullable|image|mimes:jpg,png,jpeg',
            'favicon' => 'nullable|image|mimes:jpg,png,jpeg',
        ]);

        $setting = SettingService::getSetting();
        $logo = $setting->logo;

        if($request->hasFile('dark')) {
            Arr::set($logo, 'dark', $this->move($request->file('dark'), getFilePath(), Arr::get($setting->logo, 'dark')));
        }

        if($request->hasFile('white')) {
            Arr::set($logo, 'white', $this->move($request->file('white'), getFilePath(), Arr::get($setting->logo, 'white')));
        }

        if($request->hasFile('favicon')) {
            Arr::set($logo, 'favicon', $this->move($request->file('favicon'), getFilePath(), Arr::get($setting->logo, 'favicon')));
        }

        $setting->logo = $logo;
        $setting->save();

        return back()->with('notify', [['success', __('The dark logo, white logo, and favicon have been refreshed.')]]);
    }


    /**
     * @return View
     */
    public function security(): View
    {
        $setTitle = __('admin.security.page_title.security');

        return view('admin.setting.security', compact('setTitle'));
    }

    public function blockIp(): View
    {
        $setTitle = __('admin.security.page_title.block_ip');
        $blockIps = BlockIp::latest()->paginate(getPaginate());

        return view('admin.setting.block_ip', compact(
            'setTitle',
            'blockIps'
        ));
    }


    public function firewall(): View
    {
        $setTitle = __('admin.security.page_title.firewall_log');
        $firewallLogs = FirewallLog::latest()->paginate(getPaginate());

        return view('admin.setting.firewall', compact(
            'setTitle',
            'firewallLogs',
        ));
    }

    public function language(): RedirectResponse
    {
        $contribute = Contributor::where('role', RoleEnum::OWNER->value)->first();
        if($contribute){
            Auth::guard('translations')->login($contribute);
        }
        return redirect(url('translations'));
    }


    public function systemUpdate(): View
    {
        $setTitle = 'System update';

        return view('admin.setting.system-update', compact(
            'setTitle',
        ));
    }

    public function systemMigrate(Request $request): RedirectResponse
    {
        Artisan::call('migrate', [
            '--force' => true,
        ]);

        $this->environmentHelper->putPermanentEnv('APP_CURRENT_VERSION', config('app.migrate_version'));
        Artisan::call('optimize:clear');
        Artisan::call('config:clear');

        return back()->with('notify', [['success', __('System has been updated successfully')]]);
    }


    public function themeIndex(): View
    {
        $setTitle = 'Theme Setting';
        $setting = SettingService::getSetting();
        $theme = $setting->theme_template_setting;
        $activeTheme = $theme['themes'][$theme['currently_active']] ?? [];

        return view('admin.setting.theme', compact(
            'setTitle',
            'activeTheme',
        ));
    }


    public function themeUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'theme' => ['required', 'string', 'max:255'],
        ]);

        $setting = SettingService::getSetting();
        $themeTemplateSetting = $setting->theme_template_setting;
        $themeTemplateSetting['currently_active'] = $request->input('theme');
        $setting->theme_template_setting = $themeTemplateSetting;
        $setting->save();

        return back()->with('notify', [['success', __('Theme template setting has been updated successfully')]]);
    }

    /**
     * @return RedirectResponse
     */
    public function cacheClear(): RedirectResponse
    {
        Artisan::call('optimize:clear');
        return back()->with('notify', [['success', __('admin.setting.notify.cache.success')]]);
    }
}
