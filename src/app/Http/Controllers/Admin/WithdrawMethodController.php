<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawRequest;
use App\Models\WithdrawMethod;
use App\Services\Payment\WithdrawGatewayService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class WithdrawMethodController extends Controller
{
    public function __construct(public WithdrawGatewayService $gatewayService)
    {

    }

    public function index(): View
    {
        $setTitle = __('admin.withdraw.page_title.gateway.index');
        $withdrawMethods = WithdrawMethod::orderBy('id')->paginate(getPaginate());

        return view('admin.withdraw_method.index', compact('setTitle', 'withdrawMethods'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $setTitle = __('admin.withdraw.page_title.gateway.create');
        return view('admin.withdraw_method.create', compact('setTitle'));
    }

    /**
     * @param WithdrawRequest $request
     * @return RedirectResponse
     */
    public function store(WithdrawRequest $request): RedirectResponse
    {
        $this->gatewayService->save($this->gatewayService->prepParams($request));
        return back()->with('notify', [['success', __('admin.withdraw.notify.gateway.create.success')]]);
    }

    public function edit(int|string $id): View
    {
        $setTitle = __('admin.withdraw.page_title.gateway.update');

        $withdrawMethod = $this->gatewayService->findById($id);
        if(blank($withdrawMethod)) abort(404);

        return view('admin.withdraw_method.edit', compact('setTitle', 'withdrawMethod'));
    }


    public function update(WithdrawRequest $request, int|string $id): RedirectResponse
    {
        $withdrawGateway = $this->gatewayService->findById($id);
        if(blank($withdrawGateway)) abort(404);

        $params = $this->gatewayService->prepParams($request);

        if(is_null(Arr::get($params, 'file'))){
            Arr::set($params, 'file', $withdrawGateway->file);
        }

        $withdrawGateway->update($params);
        return back()->with('notify', [['success', __('admin.withdraw.notify.gateway.update.success')]]);
    }
}
