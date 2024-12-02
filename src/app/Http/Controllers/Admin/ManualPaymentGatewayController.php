<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Payment\GatewayType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentGatewayRequest;
use App\Services\Payment\PaymentGatewayService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class ManualPaymentGatewayController extends Controller
{
    public function __construct(protected PaymentGatewayService $paymentGatewayService){

    }

    /**
     * @return View
     */
    public function index(): View
    {
        $setTitle = __('admin.payment_processor.page_title.traditional.index');
        $gateways = $this->paymentGatewayService->getGatewayByPaginate(GatewayType::MANUAL);

        return view('admin.payment_gateway.manual.index', compact(
            'setTitle',
            'gateways'
        ));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $setTitle = __('admin.payment_processor.page_title.traditional.create');

        return view('admin.payment_gateway.manual.create', compact(
            'setTitle'
        ));
    }

    /**
     * @param PaymentGatewayRequest $request
     * @return RedirectResponse
     */
    public function store(PaymentGatewayRequest $request): RedirectResponse
    {
        $this->paymentGatewayService->save($this->paymentGatewayService->prepParams($request, GatewayType::MANUAL));
        return back()->with('notify', [['success', __('admin.payment_processor.notify.traditional.create.success')]]);
    }

    /**
     * @param string|int $id
     * @return View
     */
    public function edit(string|int $id): View
    {
        $setTitle = __('admin.payment_processor.page_title.traditional.edit');
        $traditionalGateway = $this->paymentGatewayService->findById($id);

        if(blank($traditionalGateway)) abort(404);

        return view('admin.payment_gateway.manual.edit', compact(
            'setTitle',
            'traditionalGateway'
        ));
    }

    public function update(PaymentGatewayRequest $request, string|int $id): RedirectResponse
    {
        $traditionalGateway = $this->paymentGatewayService->findById($id);
        if(blank($traditionalGateway)) abort(404);

        $params = $this->paymentGatewayService->prepParams($request, GatewayType::MANUAL);
        if(is_null(Arr::get($params, 'file'))){
            Arr::set($params, 'file', $traditionalGateway->file);
        }

        $traditionalGateway->update($params);
        return back()->with('notify', [['success', __('admin.payment_processor.notify.traditional.update.success')]]);
    }

}
