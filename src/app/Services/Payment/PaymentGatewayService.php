<?php

namespace App\Services\Payment;

use App\Concerns\BuildParameter;
use App\Concerns\UploadedFile;
use App\Enums\Payment\GatewayType;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Str;

class PaymentGatewayService
{
    use UploadedFile, BuildParameter;

    /**
     * @param int|string $id
     * @return PaymentGateway|null
     */
    public function findById(int|string $id): ?PaymentGateway
    {
        return PaymentGateway::find($id);
    }


    public function getGatewayByPaginate(GatewayType $gatewayType): AbstractPaginator
    {
        return PaymentGateway::where('type', $gatewayType->value)->orderBy('id','ASC')->paginate(getPaginate());
    }

    public function prepParams(Request $request, GatewayType $gatewayType): array
    {
        return [
            'name' => $request->input('name'),
            'currency' => $request->input('currency'),
            'percent_charge' => $request->input('percent_charge'),
            'rate' => $request->input('rate'),
            'minimum' => $request->input('minimum'),
            'maximum' => $request->input('maximum'),
            'code' => Str::random(5),
            'file' =>  $request->hasFile('image') ? $this->move($request->file('image'), getFilePath()) : null,
            'parameter' => $this->buildParameters($request),
            'type' => $gatewayType->value,
            'details' => $request->input('details'),
            'status' => $request->input('status'),
        ];
    }

    public function save(array $params): PaymentGateway
    {
        return PaymentGateway::create($params);
    }

}
