<?php

namespace App\Http\Controllers\Admin\Investment;

use App\Http\Controllers\Controller;
use App\Services\PinGenerateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PinGenerateController extends Controller
{
    public PinGenerateService $pinGenerateService;

    public function __construct(PinGenerateService $pinGenerateService)
    {
        $this->pinGenerateService = $pinGenerateService;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $setTitle = __('admin.pin.page_title.index');
        $pins = $this->pinGenerateService->getPinsByPaginate();

        return view('admin.pin_generate.index', compact('setTitle', 'pins'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'amount' => ['required','numeric','gt:0'],
            'number' => ['required','integer','gt:0']
        ]);

        $this->pinGenerateService->save($this->pinGenerateService->prepParams($request->integer('number'), $request->input('amount'), "Created by a system administrator"));
        return back()->with('notify', [['success', __('admin.pin.notify.create.success')]]);
    }

}
