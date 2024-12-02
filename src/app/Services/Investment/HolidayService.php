<?php

namespace App\Services\Investment;

use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;

class HolidayService
{
    /**
     * @return AbstractPaginator
     */
    public function getByPaginate(): AbstractPaginator
    {
        return Holiday::latest()->paginate(getPaginate());
    }
    /**
     * @param int|string $id
     * @return Holiday|null
     */
    public function findById(int|string $id): ?Holiday
    {
        return Holiday::find($id);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function prepParams(Request $request): array
    {
        return [
            'date' => $request->input('date'),
            'name' => $request->input('name'),
        ];
    }

    /**
     * @param array $params
     * @return Holiday
     */
    public function save(array $params): Holiday
    {
        return Holiday::create($params);
    }

    /**
     * @param Request $request
     * @return Holiday|null
     */
    public function update(Request $request): ?Holiday
    {
        $holiday = $this->findById($request->integer('id'));

        if(is_null($holiday)){
            return null;
        }

        $holiday->update($this->prepParams($request));
        return $holiday;
    }
}
