<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeeLeaveBalanceRepository;
use App\Repositories\LeaveTypeRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\ShiftGroupRepository;
use App\Repositories\EmployeeShiftGroupRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class EmployeeLeaveBalanceController extends Controller
{
    protected $employee_leave_balance_repository;
    protected $leaveTypeRepository;
    protected $employee_repository;
    protected $log_repository;
    protected $shift_group_repository;
    protected $employee_shift_group_repository;

    public function __construct(
        EmployeeLeaveBalanceRepository $employee_leave_balance_repository,
        EmployeeRepository $employee_repository,
        LeaveTypeRepository $leaveTypeRepository,
        ShiftGroupRepository $shift_group_repository,
        EmployeeShiftGroupRepository $employee_shift_group_repository,
        LogRepository $log_repository
    ) {
        $this->employee_leave_balance_repository = $employee_leave_balance_repository;
        $this->leaveTypeRepository = $leaveTypeRepository;
        $this->employee_repository = $employee_repository;
        $this->shift_group_repository = $shift_group_repository;
        $this->employee_shift_group_repository = $employee_shift_group_repository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        try {
            $employee_leave_balance = $this->employee_leave_balance_repository->getList();
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong while retrieving employee leave balance');
        }
        return view('employee_leave_balance.index', ['employee_leave_balance' => $employee_leave_balance]);
    }
    public function store(Request $request)
    {
        $chosenEmployees = $request->input('chosen_employees');
        $data = $request->only([
            'leave_type_id',
            'leave_status',
        ]);
        $leave_type = $this->leaveTypeRepository->show($data['leave_type_id']);
        foreach ($chosenEmployees as $employee_id) {
            $employee_mass_leave = [
                "employee_id" => $employee_id,
                "leave_type_id" => $data['leave_type_id'],
                "leave_status" => $data['leave_status'],
                "balance" => $leave_type->eligibility_leave,
            ];
            $this->log_repository->logActivity('Created employee leave balance', $request->ip());
            $this->employee_leave_balance_repository->create($employee_mass_leave);
        }
        return redirect()->route('admin.employee_leave_balance')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        $employees = $this->employee_repository->getListParams();
        $leave_type = $this->leaveTypeRepository->getList();
        $groups = $this->shift_group_repository->getList();
        foreach ($employees as $employee) {
            if ($this->employee_shift_group_repository->getEmployeeGroup($employee->id)) {
                $employee->group_id = $this->employee_shift_group_repository->getEmployeeGroup($employee->id)->shift_group_id;
            } else {
                $employee->group_id = 0;
            }
        }
        return view('employee_leave_balance.create', ['employees' => $employees, 'leave_type' => $leave_type, 'groups' => $groups]);
    }

    public function edit($id)
    {
        $leave_type = $this->leaveTypeRepository->getList();
        $employee_leave_balance = $this->employee_leave_balance_repository->show($id);
        return view('employee_leave_balance.edit', ['employee_leave_balance' => $employee_leave_balance, 'leave_type' => $leave_type]);
    }

    public function show($id)
    {
        $employee_leave_balance = $this->employee_leave_balance_repository->show($id);
        return view('employee_leave_balance.show', ['employee_leave_balance' => $employee_leave_balance]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'leave_type_id',
            'leave_status',
            'balance',
        ]);
        $succesStatus = $this->employee_leave_balance_repository->update($id, $data);
        $this->log_repository->logActivity('Updated employee leave balance with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_leave_balance')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->employee_leave_balance_repository->delete($id);
        $this->log_repository->logActivity('Deleted employee leave balance with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_leave_balance')->with('success', 'Data updated successfully!');
    }
}
