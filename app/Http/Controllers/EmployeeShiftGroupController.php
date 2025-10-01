<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeeShiftGroupRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\ShiftGroupRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class EmployeeShiftGroupController extends Controller
{
    protected $employee_shift_group_repository;
    protected $employee_repository;
    protected $shiftGroupRepository;
    protected $log_repository;

    public function __construct(
        EmployeeShiftGroupRepository $employee_shift_group_repository,
        EmployeeRepository $employee_repository,
        ShiftGroupRepository $shiftGroupRepository,
        LogRepository $log_repository
    ) {
        $this->employee_shift_group_repository = $employee_shift_group_repository;
        $this->employee_repository = $employee_repository;
        $this->shiftGroupRepository = $shiftGroupRepository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        $employee_shift_group = $this->employee_shift_group_repository->getList();
        return view('employee_shift_group.index', ['employee_shift_group' => $employee_shift_group]);
    }
    public function store(Request $request)
    {
        $chosenEmployees = $request->input('chosen_employees');
        $data = $request->only([
            'shift_group_id',
            'start_shift_date',
            //'start_shift_daily',
            //'always_present',
            'employee_id',
            'end_date'
        ]);
        foreach ($chosenEmployees as $employee_id) {
            $employee_shift_group = [
                "employee_id" => $employee_id,
                "shift_group_id" => $data['shift_group_id'],
                "start_shift_date" => $data['start_shift_date'],
                //"start_shift_daily" => $data['start_shift_daily'],
            ];
            $this->employee_shift_group_repository->create($employee_shift_group);
            $this->log_repository->logActivity('Created employee shift group', $request->ip());
        }
        return redirect()->route('admin.employee_shift_group')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        $employees = $this->employee_repository->getListParams();
        $shift_groups = $this->shiftGroupRepository->getList();
        return view('employee_shift_group.create', ['shift_groups' => $shift_groups, 'employees' => $employees]);
    }

    public function edit($id)
    {
        $shift_groups = $this->shiftGroupRepository->getList();
        $employee_shift_group = $this->employee_shift_group_repository->show($id);
        return view('employee_shift_group.edit', ['employee_shift_group' => $employee_shift_group, 'shift_groups' => $shift_groups]);
    }

    public function show($id)
    {
        $employee_shift_group = $this->employee_shift_group_repository->show($id);
        return view('employee_shift_group.show', ['employee_shift_group' => $employee_shift_group]);
    }

    public function update(Request $request, $id)
    {
        $data =  $request->only([
            'shift_group_id',
            'start_shift_date',
            'end_date'
        ]);

        $succesStatus = $this->employee_shift_group_repository->update($id, $data);
        $this->log_repository->logActivity('Updated employee shift group with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_shift_group')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->employee_shift_group_repository->delete($id);
        $this->log_repository->logActivity('Deleted employee shift group with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_shift_group')->with('success', 'Data updated successfully!');
    }
}
