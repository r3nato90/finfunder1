<?php

namespace App\Http\Controllers\Admin\Trade;

use App\Http\Controllers\Controller;
use App\Services\Trade\CryptoCurrencyService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CryptoCurrencyController extends Controller
{
    public CryptoCurrencyService $cryptoCurrencyService;

    public function __construct(CryptoCurrencyService $cryptoCurrencyService)
    {
        $this->cryptoCurrencyService = $cryptoCurrencyService;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $setTitle = __('admin.crypto_currency.page_title.index');
        $cryptoCurrencies = $this->cryptoCurrencyService->getCryptoCurrencyByPaginate();

        return view('admin.trade.crypto.index', compact('setTitle', 'cryptoCurrencies'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {

        $crypto = $this->cryptoCurrencyService->findById($request->input('id'));

        if(!$crypto){
            abort(404);
        }

        $crypto->status = $request->input('status');
        $crypto->save();

        return back()->with('notify', [['success', __('admin.crypto_currency.notify.update.success')]]);
    }

}
