<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\HolidayRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class HolidayController extends Controller
{
    protected $holiday_repository;
    protected $log_repository;

    public function __construct(
        HolidayRepository $holiday_repository,
        LogRepository $log_repository
    ) {
        $this->holiday_repository = $holiday_repository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        $holiday = $this->holiday_repository->getList();
        return view('holiday.index', ['holiday' => $holiday]);
    }
    public function store(Request $request)
    {
        $data = $request->only([
            'holiday_name',
            'start_date',
            'end_date',
            'holiday_type',
            'religion',
            'nationality',
            'recur_every_year',
        ]);
        $succesStatus = $this->holiday_repository->create($data);
        $this->log_repository->logActivity('Created holiday', $request->ip());
        return redirect()->route('admin.holiday')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        return view('holiday.create');
    }

    public function edit($id)
    {
        $holiday = $this->holiday_repository->show($id);
        return view('holiday.edit', ['holiday' => $holiday]);
    }

    public function show($id)
    {
        $holiday = $this->holiday_repository->show($id);
        return view('holiday.show', ['holiday' => $holiday]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'holiday_name',
            'start_date',
            'end_date',
            'holiday_type',
            'religion',
            'nationality',
            'recur_every_year',
        ]);
        $succesStatus = $this->holiday_repository->update($id, $data);
        $this->log_repository->logActivity('Updated holiday with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.holiday')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->holiday_repository->delete($id);
        $this->log_repository->logActivity('Deleted holiday with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.holiday')->with('success', 'Data updated successfully!');
    }
}
