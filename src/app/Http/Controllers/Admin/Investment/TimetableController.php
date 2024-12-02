<?php

namespace App\Http\Controllers\Admin\Investment;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimetableRequest;
use App\Services\Investment\TimeTableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TimetableController extends Controller
{
    public function __construct(
        protected TimeTableService  $timeTableService
    ){

    }

    public function index(): View
    {
        $setTitle = __('Timetable for Investment Plans');
        $timeTables = $this->timeTableService->getByPaginate();

        return view('admin.binary.time-table', compact(
            'setTitle',
            'timeTables'
        ));
    }


    /**
     * @param TimetableRequest $request
     * @return RedirectResponse
     */
    public function store(TimetableRequest $request): RedirectResponse
    {
        $this->timeTableService->save($this->timeTableService->prepParams($request));
        return back()->with('notify', [['success', __('Timetable has been added successfully')]]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $this->timeTableService->update($request);
        return back()->with('notify', [['success', __('Timetable has been updated successfully')]]);
    }
}
