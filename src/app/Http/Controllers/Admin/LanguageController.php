<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class LanguageController extends Controller
{
    public function index(): View
    {
        $setTitle = 'Language Manager';
        $languages = Language::orderBy('is_default','desc')->paginate(getPaginate());

        return view('admin.language.index', compact(
            'setTitle',
            'languages'
        ));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:40',
            'code' => 'required|string|max:40|unique:ltu_languages'
        ]);

        $data = file_get_contents(resource_path('lang/') . 'en.json');
        $json_file = strtolower($request->code) . '.json';
        $path = resource_path('lang/') . $json_file;
        File::put($path, $data);

        $language = new Language();
        if ($request->input('is_default')) {
            $lang = $language->where('is_default', Status::ACTIVE->value)->first();
            if ($lang) {
                $lang->is_default = Status::INACTIVE->value;
                $lang->save();
            }
        }
        $language->name = $request->input('name');
        $language->code = strtolower($request->input('code'));
        $language->is_default = $request->input('is_default') ? Status::ACTIVE->value : Status::INACTIVE->value;
        $language->save();

        return back()->with('notify', [['success', __('Language added successfully')]]);
    }


    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        $language = Language::findOrFail($request->input('id'));
        if (!$request->input('is_default')) {
            $defaultLang = Language::where('is_default', Status::ACTIVE->value)->where('id','!=',$id)->exists();
            if (!$defaultLang) {
                return back()->with('notify', [['error', __('You\'ve to set another language as default before unset this')]]);
            }
        }

        $language->name = $request->input('name');
        $language->is_default = $request->input('is_default');
        $language->save();

        if ($request->input('is_default')) {
            $lang = Language::where('is_default', Status::ACTIVE->value)->where('id','!=',$language->id)->first();
            if ($lang) {
                $lang->is_default = Status::INACTIVE->value;
                $lang->save();
            }
        }

        return back()->with('notify', [['success', __('Language has been updated')]]);
    }


    public function delete(Request $request): RedirectResponse
    {
        $lang = Language::find($request->input('id'));
        $this->removeFile(resource_path('lang/') . $lang->code . '.json');
        $lang->delete();

        return back()->with('notify', [['success', __('Language has been deleted')]]);
    }

    public function edit(string|int $id): View
    {
        $language = Language::find($id);
        $setTitle = "Update " . $language->name . " Keywords";
        $json = file_get_contents(resource_path('lang/') . $language->code . '.json');
        $languages = Language::all();

        if (empty($json)) {
            return back()->with('notify', [['success', __('File Not found')]]);
        }

        $json = json_decode($json);
        return view('admin.language.edit', compact('setTitle', 'json', 'language', 'languages'));
    }


    public function import(Request $request, string|int $id)
    {
        $language = Language::find($id);
        $fromLanguage = Language::find($request->input('from_language'));
        $json = file_get_contents(resource_path('lang/') . $fromLanguage->code . '.json');

        $jsonArray = json_decode($json, true);
        file_put_contents(resource_path('lang/') . $language->code . '.json', json_encode($jsonArray));

        return back()->with('notify', [['success', __('imported')]]);
    }


    public function storeLanguageJsonFile(Request $request, string|int $id)
    {
        $request->validate([
            'key' => 'required',
            'value' => 'required'
        ]);

        $language = Language::find($id);
        $items = file_get_contents(resource_path('lang/') . $language->code . '.json');
        $requestKey = trim($request->input('key'));

        if (array_key_exists($requestKey, json_decode($items, true))) {
            return back()->with('notify', [['error', __('Key already exist')]]);
        } else {
            $newArray[$requestKey] = trim($request->input('value'));
            $itemData = json_decode($items, true);
            $result = array_merge($itemData, $newArray);

            file_put_contents(resource_path('lang/') . $language->code . '.json', json_encode($result));
            return back()->with('notify', [['success', __('Language key has been added')]]);
        }
    }

    public function deleteLanguageJsonFile(Request $request, string|int $id)
    {
        $request->validate([
            'key' => 'required',
            'value' => 'required'
        ]);

        $language = Language::find($id);
        $data = file_get_contents(resource_path('lang/') . $language->code . '.json');
        $jsonArray = json_decode($data, true);
        unset($jsonArray[$request->input('key')]);
        file_put_contents(resource_path('lang/'). $language->code . '.json', json_encode($jsonArray));

        return back()->with('notify', [['success', __('Language key has been deleted')]]);
    }



    public function updateLanguageJsonFile(Request $request, string|int $id)
    {
        $request->validate([
            'key' => 'required',
            'value' => 'required'
        ]);

        $language = Language::find($id);
        $data = file_get_contents(resource_path('lang/') . $language->code . '.json');
        $jsonArray = json_decode($data, true);
        $jsonArray[trim($request->input('key'))] = $request->input('value');
        file_put_contents(resource_path('lang/'). $language->code . '.json', json_encode($jsonArray));

        return back()->with('notify', [['success', __('Language key has been updated')]]);
    }


    protected function removeFile(?string $path = null)
    {
        file_exists($path) && is_file($path) ? @unlink($path) : false;
    }

}
