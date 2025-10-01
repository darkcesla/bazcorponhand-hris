<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\ShiftGroupRepository;
use App\Repositories\ShiftDailyRepository;
use App\Repositories\ShiftGroupDetailRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class ShiftGroupController extends Controller
{
    protected $shiftGroupRepository;
    protected $shiftDailyRepository;
    protected $shiftGroupDetailRepository;
    protected $log_repository;

    public function __construct(
        ShiftGroupRepository $shiftGroupRepository,
        ShiftDailyRepository $shiftDailyRepository,
        ShiftGroupDetailRepository $shiftGroupDetailRepository,
        LogRepository $log_repository
    ) {
        $this->shiftGroupRepository = $shiftGroupRepository;
        $this->shiftDailyRepository = $shiftDailyRepository;
        $this->shiftGroupDetailRepository = $shiftGroupDetailRepository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        $shift_groups = $this->shiftGroupRepository->getList();
        return view('shift_group.index', ['shift_groups' => $shift_groups]);
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'group_code',
            'group_name',
            'total_days',
            'start_date',
        ]);
        $shiftGroup = $this->shiftGroupRepository->create($data);
        $this->log_repository->logActivity('Created shift group', $request->ip());
        $shift_data = $request->input('shift_data');
        if (is_string($shift_data)) {
            $shift_data = json_decode($shift_data, true);
        }
        $shiftGroupDetails = [];
        foreach ($shift_data as $shift) {
            array_push(
                $shiftGroupDetails,
                [
                    'shift_daily_id' => $shift['shift_daily_id'],
                    'shift_group_id' => $shiftGroup->id,
                    'day_order' => $shift['day_order']
                ]
            );
        }
        $this->shiftGroupDetailRepository->create($shiftGroupDetails);
        return redirect()->route('admin.shift_group')->with('success', 'Data inserted successfully!');
    }

    public function create()
    {
        $shiftDaily = $this->shiftDailyRepository->getList();
        return view('shift_group.create', ['shiftDaily' => $shiftDaily]);
    }

    public function edit($id)
    {
        $shiftGroup = $this->shiftGroupRepository->show($id);
        $shiftDaily = $this->shiftDailyRepository->getList();
        $shiftDetail = $this->shiftGroupDetailRepository->getList($id);
        return view('shift_group.edit', ['shiftGroup' => $shiftGroup, 'shiftDaily' => $shiftDaily, 'shiftDetail' => $shiftDetail]);
    }

    public function show($id)
    {
        $shiftDetail = $this->shiftGroupDetailRepository->getList($id);
        $shift_group = $this->shiftGroupRepository->show($id);
        return view('shift_group.show', ['shift_group' => $shift_group, 'shiftDetail' => $shiftDetail]);
    }

    public function update(Request $request, int $id)
    {
        $shift_data = $request->input('shift_data');
        $data = $request->only([
            'group_code',
            'group_name',
            'total_days',
            'start_date',
        ]);
        $shiftGroup = $this->shiftGroupRepository->update($id, $data);
        $this->log_repository->logActivity('Updated shift group with id: ' . $id, '', $request->ip());
        $this->shiftGroupDetailRepository->batchDelete($id);
        if (is_string($shift_data)) {
            $shift_data = json_decode($shift_data, true);
        }
        $shiftGroupDetails = [];
        foreach ($shift_data as $shift) {
            array_push(
                $shiftGroupDetails,
                [
                    'shift_daily_id' => $shift['shift_daily_id'],
                    'shift_group_id' => $id,
                    'day_order' => $shift['day_order']
                ]
            );
        }
        $this->shiftGroupDetailRepository->create($shiftGroupDetails);
        return redirect()->route('admin.shift_group')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->shiftGroupRepository->delete($id);
        $this->log_repository->logActivity('Deleted shift group with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.shift_group')->with('success', 'Data updated successfully!');
    }
}
