<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Frontend\Content;
use App\Http\Controllers\Controller;
use App\Http\Requests\FrontendRequest;
use App\Models\Frontend;
use App\Services\FrontendService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FrontendController extends Controller
{
    public function __construct(protected FrontendService $frontendService){

    }

    /**
     * @param string $key
     * @return View
     */
    public function index(string $key): View
    {
        $section = $this->frontendService->findBySectionKey($key) ?? abort(404);
        $setTitle = Arr::get($section, 'name');
        $getFixedContent = $this->frontendService->getFixedContent($key);
        $getEnhancementContents = $this->frontendService->getEnhancementContent($key);

        return view('admin.frontend.index', compact(
            'section', 'getFixedContent', 'getEnhancementContents', 'key', 'setTitle'
        ));
    }

    /**
     * @param FrontendRequest $request
     * @param string $key
     * @return RedirectResponse
     */
    public function save(FrontendRequest $request, string $key): RedirectResponse
    {
        $sectionImages = $this->frontendService->findBySectionKey("{$key}.{$request->input('content')}.images");
        $preparePrams = $this->frontendService->processInputs($request,$sectionImages);

        if (!$preparePrams || !is_array($preparePrams)){
            $notify[] = ['error', 'Something is wrong'];
            return redirect()->route('admin.frontend.section.index', $key)->withNotify($notify);
        }

        $this->frontendService->save($request, $preparePrams, $key);

        $notify[] = ['success', 'Content has been updated.'];
        return redirect()->route('admin.frontend.section.index', $key)->withNotify($notify);
    }

    /**
     * @param string $key
     * @param $id
     * @return View
     */
    public function getContent(string $key, $id = null): View
    {
        $section = $this->frontendService->findBySectionKey($key) ?? abort(404);
        $setTitle = Arr::get($section, 'name');
        $frontend = $id ? $this->frontendService->findById($id) : null;

        return view('admin.frontend.element', compact('section', 'key', 'setTitle', 'frontend'));
    }


    public function delete(Request $request)
    {
        $request->validate([
            'id' => ['required', Rule::exists('frontends', 'id')]
        ]);

        $frontend = Frontend::findOrFail($request->input('id'));
        $frontend->delete();

        $notify[] = ['success', 'Frontend section content has been removed.'];
        return back()->withNotify($notify);
    }

}
