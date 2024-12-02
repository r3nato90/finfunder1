<?php

namespace App\Services\Payment;

use App\Concerns\BuildParameter;
use App\Concerns\UploadedFile;
use App\Enums\Payment\Withdraw\MethodStatus;
use App\Models\WithdrawMethod;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class WithdrawGatewayService
{
    use UploadedFile, BuildParameter;

    /**
     * @param string|int $id
     * @return WithdrawMethod|null
     */
    public function findById(string|int $id): ?WithdrawMethod
    {
        return WithdrawMethod::find($id);
    }

    public function prepParams(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'currency_name' => $request->input('currency_name'),
            'min_limit' => $request->input('min_limit'),
            'max_limit' => $request->input('max_limit'),
            'percent_charge' => $request->input('percent_charge'),
            'fixed_charge' => $request->input('fixed_charge'),
            'rate' => $request->input('rate'),
            'file' =>  $request->hasFile('image') ? $this->move($request->file('image'), getFilePath()) : null,
            'parameter' => $this->buildParameters($request),
            'instruction' => null,
            'status' => $request->input('status'),
        ];
    }

    public function save(array $params): WithdrawMethod
    {
        return WithdrawMethod::create($params);
    }

    /**
     * @return Collection
     */
    public function fetchActiveWithdrawMethod(): Collection
    {
        return WithdrawMethod::where('status', MethodStatus::ACTIVE->value)
            ->orderBy('id')
            ->get();
    }

}
