<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\PluginConfiguration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PluginConfigurationController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $setTitle = __('admin.setting.page_title.plugin');
        $plugins = PluginConfiguration::get();

        return view('admin.plugin.index', compact('setTitle','plugins'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'api_key' => 'required',
            'code' => ['required', Rule::exists('plugin_configurations', 'code')],
            'status' => ['required', Rule::in(Status::values())],
        ]);

        $plugin = PluginConfiguration::where('code', $request->input('code'))->firstOrFail();
        $plugin->short_key = [
            'api_key' => $request->input('api_key'),
        ];
        $plugin->status= $request->input('status');
        $plugin->save();

        return back()->with('notify', [['success', __('admin.setting.notify.plugin.success', ['name' =>$plugin->name])]]);
    }
}
