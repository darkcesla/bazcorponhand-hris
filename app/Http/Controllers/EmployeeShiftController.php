<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeeShiftRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeShiftImport;
use App\Repositories\ShiftDailyRepository;
use App\Repositories\AttendanceRepository;
use App\Repositories\ShiftGroupRepository;
use App\Repositories\EmployeeShiftGroupRepository;
use App\Repositories\LogRepository;
use App\Repositories\UserRepository;

class EmployeeShiftController extends Controller
{
    protected $employee_shift_repository;
    protected $employee_repository;
    protected $shiftDailyRepository;
    protected $attendanceRepository;
    protected $log_repository;
    protected $shift_group_repository;
    protected $employee_shift_group_repository;
    protected $user_repository;

    public function __construct(
        EmployeeShiftRepository $employee_shift_repository,
        EmployeeRepository $employee_repository,
        ShiftDailyRepository $shiftDailyRepository,
        AttendanceRepository $attendanceRepository,
        ShiftGroupRepository $shift_group_repository,
        EmployeeShiftGroupRepository $employee_shift_group_repository,
        LogRepository $log_repository,
        UserRepository $user_repository
    ) {
        $this->employee_shift_repository = $employee_shift_repository;
        $this->employee_repository = $employee_repository;
        $this->shiftDailyRepository = $shiftDailyRepository;
        $this->attendanceRepository = $attendanceRepository;
        $this->shift_group_repository = $shift_group_repository;
        $this->employee_shift_group_repository = $employee_shift_group_repository;
        $this->log_repository = $log_repository;
        $this->user_repository = $user_repository;
    }

    public function index()
    {
        $params = [];
        $employee_shift = $this->employee_shift_repository->getList($params);
        return view('employee_shift.index', ['employee_shift' => $employee_shift]);
    }
    public function store(Request $request)
    {
        $data = $request->only([
            'employee_id',
            'date',
            'shift_daily_id',
        ]);
        $succesStatus = $this->employee_shift_repository->create($data);
        $this->log_repository->logActivity('Created attendance', $request->ip());
        $attendance['shift_daily_id'] = $data['shift_daily_id'];
        $attendance['date'] = $data['date'];
        $attendance['employee_id'] =  $data['employee_id'];
        $attendance['status'] = 0;
        $this->attendanceRepository->create($attendance);
        $this->log_repository->logActivity('Create employee shift', $request->ip());
        return redirect()->route('admin.employee_shift')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        $employees = $this->employee_repository->getListParams();
        $shift_daily = $this->shiftDailyRepository->getList();
        $groups = $this->shift_group_repository->getList();
        foreach ($employees as $employee) {
            if ($this->employee_shift_group_repository->getEmployeeGroup($employee->id)) {
                $employee->group_id = $this->employee_shift_group_repository->getEmployeeGroup($employee->id)->shift_group_id;
            } else {
                $employee->group_id = 0;
            }
        }
        return view('employee_shift.create', ['shift_daily' => $shift_daily, 'employees' => $employees, 'groups' => $groups]);
    }

    public function edit($id)
    {
        $shift_daily = $this->shiftDailyRepository->getList();
        $employee_shift = $this->employee_shift_repository->show($id);
        return view('employee_shift.edit', ['employee_shift' => $employee_shift, 'shift_daily' => $shift_daily]);
    }

    public function show($id)
    {
        $employee_shift = $this->employee_shift_repository->show($id);
        return view('employee_shift.show', ['employee_shift' => $employee_shift]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'employee_id',
            'date',
            'shift_daily_id',
        ]);
        $succesStatus = $this->employee_shift_repository->update($id, $data);
        $this->log_repository->logActivity('Updated employee shift with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_shift')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->employee_shift_repository->delete($id);
        $this->log_repository->logActivity('Deleted employee shift with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_shift')->with('success', 'Data updated successfully!');
    }

    public function get(Request $request)
    {
        $token = $request->header('token');
        if (empty($token)) {
            return response()
                ->json(['message' => 'Token not provided', 'data' => null], 401);
        }
        try {
            $employee = $this->user_repository->checkToken($token);
            if (!$employee) {
                return response()
                    ->json(['message' => 'Invalid token', 'data' => null], 401);
            }
            $data = $request->only(['page', 'per_page']);
            $data['employee_id'] = $employee->id;
            $employee_shift = $this->employee_shift_repository->getMonthList($data);
            if (empty($employee_shift)) {
                return response()
                    ->json(['message' => 'No data found', 'data' => null], 404);
            }
            $nextPageUrl = $employee_shift->nextPageUrl();
            $previousPageUrl = $employee_shift->previousPageUrl();
            $total = $employee_shift->total();
            $perPage = $employee_shift->perPage();
            $currentPage = $employee_shift->currentPage();
            $lastPage = $employee_shift->lastPage();
            $response = [
                'message' => 'success',
                'data' => $employee_shift->items(),
                'next_page_url' => $nextPageUrl,
                'previous_page_url' => $previousPageUrl,
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $currentPage,
                'last_page' => $lastPage,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new EmployeShiftImport(), $request->file('file'));
            return redirect()->back();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
