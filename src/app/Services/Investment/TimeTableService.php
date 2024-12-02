<?php

namespace App\Services\Investment;

use App\Enums\Status;
use App\Models\TimeTable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;

class TimeTableService
{

    /**
     * @return AbstractPaginator
     */
    public function getByPaginate(): AbstractPaginator
    {
        return TimeTable::latest()->paginate(getPaginate());
    }


    /**
     * @return Collection
     */
    public function getActiveTime(): Collection
    {
        return TimeTable::where('status', Status::ACTIVE->value)->get();
    }


    /**
     * @param int|string $id
     * @return TimeTable|null
     */
    public function findById(int|string $id): ?TimeTable
    {
        return TimeTable::find($id);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function prepParams(Request $request): array
    {
        return [
            'time' => $request->input('time'),
            'name' => $request->input('name'),
            'status' => $request->integer('status'),
        ];
    }

    /**
     * @param array $params
     * @return TimeTable
     */
    public function save(array $params): TimeTable
    {
        return TimeTable::create($params);
    }

    /**
     * @param Request $request
     * @return TimeTable|null
     */
    public function update(Request $request): ?TimeTable
    {
        $timeTable = $this->findById($request->integer('id'));

        if(is_null($timeTable)){
            return  null;
        }

        $timeTable->update($this->prepParams($request));
        return $timeTable;
    }


}
