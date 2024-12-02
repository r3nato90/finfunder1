<?php

namespace App\Services\Trade;

use App\Enums\Trade\TradeParameterStatus;
use App\Models\TradeParameter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ParameterService
{
    /**
     * @param int|string $id
     * @return TradeParameter|null
     */
    public function findById(int|string $id): ?TradeParameter
    {
        return TradeParameter::find($id);
    }


    public function getTradeParameter()
    {
        return TradeParameter::latest()->paginate(getPaginate());
    }

    /**
     * @param Request $request
     * @return array
     */
    public function prepParams(Request $request): array
    {
        return [
            'time' => $request->input('time'),
            'unit' => $request->input('unit'),
            'status' => $request->integer('status'),
        ];
    }

    /**
     * @param array $params
     * @return TradeParameter
     */
    public function save(array $params): TradeParameter
    {
        return TradeParameter::create($params);
    }

    /**
     * @param Request $request
     * @return TradeParameter|null
     */
    public function update(Request $request): ?TradeParameter
    {
        $tradeParameter = $this->findById($request->integer('id'));

        if(is_null($tradeParameter)){
            return  null;
        }

        $tradeParameter->update($this->prepParams($request));

        return $tradeParameter;
    }


    /**
     * @return Collection
     */
    public function activeParameter(): Collection
    {
        return TradeParameter::where('status', TradeParameterStatus::ACTIVE->value)->get();
    }
}
