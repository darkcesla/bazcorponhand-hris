<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\ShiftDailyRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class ShiftDailyController extends Controller
{

    protected $shiftDailyRepository;
    protected $log_repository;

    public function __construct(
        ShiftDailyRepository $shiftDailyRepository,
        LogRepository $log_repository
    ) {
        $this->shiftDailyRepository = $shiftDailyRepository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        $shift_daily = $this->shiftDailyRepository->getList();
        return view('shift_daily.index', ['shift_daily' => $shift_daily]);
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'shift_daily_code',
            'day_type',
            'shift_daily_code_ph',
            'start_time',
            'end_time',
            'grace_for_late',
            'productive_work_time',
            'break_time',
            'remark',
        ]);

        $succesStatus = $this->shiftDailyRepository->create($data);
        $this->log_repository->logActivity('Created shift daily', $request->ip());

        return redirect()->route('admin.shift_daily')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        return view('shift_daily.create');
    }

    public function edit($id)
    {
        $shift_daily = $this->shiftDailyRepository->show($id);
        return view('shift_daily.edit', ['shift_daily' => $shift_daily]);
    }

    public function show($id)
    {
        $shift_group = $this->shiftDailyRepository->show($id);
        return view('shift_daily.show', ['shift_daily' => $shift_group]);
    }

    public function update(Request $request, $id)
    {
        $request->only([
            'shift_daily_code',
            'day_type',
            'shift_daily_code_ph',
            'start_time',
            'end_time',
            'grace_for_late',
            'productive_work_time',
            'break_start',
            'break_end',
            'remark',
        ]);
        unset($request['_token'], $request['_method']);
        $succesStatus = $this->shiftDailyRepository->update($id, $request->all());
        return redirect()->route('admin.shift_daily')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->shiftDailyRepository->delete($id);
        $this->log_repository->logActivity('Deleted shift daily with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.shift_daily')->with('success', 'Data updated successfully!');
    }
}
