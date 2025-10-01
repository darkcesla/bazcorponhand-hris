<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\MassLeaveRepository;
use App\Repositories\LeaveTypeRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\EmployeeMassLeaveRepository;
use App\Repositories\ShiftGroupRepository;
use App\Repositories\EmployeeShiftGroupRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class MassLeaveController extends Controller
{
    protected $mass_leave_repository;
    protected $leaveTypeRepository;
    protected $employee_repository;
    protected $employee_mass_leave_repository;
    protected $log_repository;
    protected $shift_group_repository;
    protected $employee_shift_group_repository;

    public function __construct(
        MassLeaveRepository $mass_leave_repository,
        LeaveTypeRepository $leaveTypeRepository,
        EmployeeRepository $employee_repository,
        EmployeeMassLeaveRepository $employee_mass_leave_repository,
        ShiftGroupRepository $shift_group_repository,
        EmployeeShiftGroupRepository $employee_shift_group_repository,
        LogRepository $log_repository
    ) {
        $this->mass_leave_repository = $mass_leave_repository;
        $this->leaveTypeRepository = $leaveTypeRepository;
        $this->employee_repository = $employee_repository;
        $this->employee_mass_leave_repository = $employee_mass_leave_repository;
        $this->shift_group_repository = $shift_group_repository;
        $this->employee_shift_group_repository = $employee_shift_group_repository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        $mass_leave = $this->mass_leave_repository->getList();
        return view('mass_leave.index', ['mass_leave' => $mass_leave]);
    }

    public function store(Request $request)
    {
        $chosenEmployees = $request->input('chosen_employees');
        $data = $request->only([
            'mass_leave_name',
            'leave_type_id',
            'start_date',
            'end_date',
        ]);
        $mass_leave = $this->mass_leave_repository->create($data);
        $this->log_repository->logActivity('Created mass leave', $request->ip());
        foreach ($chosenEmployees as $employee_id) {
            $employee_mass_leave = [
                "employee_id" => $employee_id,
                "mass_leave_id" => $mass_leave->id,
            ];
            $this->employee_mass_leave_repository->create($employee_mass_leave);
        }
        return redirect()->route('admin.mass_leave')->with('success', 'Data updated successfully!');
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
        return view('mass_leave.create', ['employees' => $employees, 'leave_type' => $leave_type, 'groups' => $groups]);
    }

    public function edit($id)
    {
        $leave_type = $this->leaveTypeRepository->getList();
        $employee = $this->employee_repository->getListParams();
        $mass_leave = $this->mass_leave_repository->show($id);
        $chosen_employee = $this->employee_mass_leave_repository->getList($id);
        $chosen_employee_id = [];
        foreach ($chosen_employee as $ce) {
            array_push($chosen_employee_id, $ce->employee_id);
        }
        $availableEmployees = $employee->reject(function ($emp) use ($chosen_employee_id) {
            return in_array($emp->id, $chosen_employee_id);
        });
        return view('mass_leave.edit', ['leave_type' => $leave_type, 'mass_leave' => $mass_leave, 'chosen_employee' => $chosen_employee, 'availableEmployees' => $availableEmployees]);
    }

    public function show($id)
    {
        $chosen_employee = $this->employee_mass_leave_repository->getList($id);
        $mass_leave = $this->mass_leave_repository->show($id);
        $chosen_employee_id = [];
        return view('mass_leave.show', ['mass_leave' => $mass_leave, 'chosen_employee' => $chosen_employee]);
    }

    public function update(Request $request, $id)
    {
        $chosenEmployees = $request->input('chosen_employees', []);
        $removedEmployees = $request->input('removed_ids', []);
        $data = $request->only([
            'mass_leave_name',
            'leave_type_id',
            'start_date',
            'end_date',
        ]);
        $this->mass_leave_repository->update($id, $data);
        $this->log_repository->logActivity('Updated mass leave with id: ' . $id, '', $request->ip());

        $exist_employee = $this->employee_mass_leave_repository->getList($id);
        $existingEmployeeIds = $exist_employee->pluck('employee_id')->toArray();
        $employeeIdsToAdd = array_diff($chosenEmployees, $existingEmployeeIds);
        if (!empty($removedEmployees)) {
            $employeeIdsToRemove = array_map('intval', explode(',', $removedEmployees));
        } else {
            $employeeIdsToRemove = [];
        }
        foreach ($employeeIdsToRemove as $employeeIdToRemove) {
            $this->employee_mass_leave_repository->delete($employeeIdToRemove);
        }
        foreach ($employeeIdsToAdd as $employeeIdToAdd) {
            $add = [
                'employee_id' => $employeeIdToAdd,
                'mass_leave_id' => $id,
            ];
            $this->employee_mass_leave_repository->create($add);
        }
        return redirect()->route('admin.mass_leave');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->mass_leave_repository->delete($id);
        $this->log_repository->logActivity('Deleted mass leave with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.mass_leave')->with('success', 'Data updated successfully!');
    }
}
