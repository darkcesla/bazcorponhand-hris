<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeeAttendanceLocationRepository;
use App\Repositories\AttendanceLocationRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class EmployeeAttendanceLocationController extends Controller
{
    protected $employee_attendance_location_repository;
    protected $attendanceLocationRepository;
    protected $employee_repository;
    protected $log_repository;

    public function __construct(
        EmployeeAttendanceLocationRepository $employee_attendance_location_repository,
        EmployeeRepository $employee_repository,
        AttendanceLocationRepository $attendanceLocationRepository,
        LogRepository $log_repository
    ) {
        $this->employee_attendance_location_repository = $employee_attendance_location_repository;
        $this->employee_repository = $employee_repository;
        $this->attendanceLocationRepository = $attendanceLocationRepository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        $employee_attendance_location = $this->employee_attendance_location_repository->getList();
        return view('employee_attendance_location.index', ['employee_attendance_location' => $employee_attendance_location]);
    }
    public function store(Request $request)
    {
        $chosenEmployees = $request->input('chosen_employees');
        $data = $request->only([
            'start_date',
            'end_date',
            'attendance_location_id',

        ]);
        foreach ($chosenEmployees as $employee_id) {
            $employee_attendance_location = [
                "employee_id" => $employee_id,
                "start_date" => $data['start_date'],
                "end_date" => $data['end_date'],
                "attendance_location_id" => $data['attendance_location_id'],
            ];
            $this->employee_attendance_location_repository->create($employee_attendance_location);
            $this->log_repository->logActivity('Created employee attendance location', $request->ip());
        }
        return redirect()->route('admin.employee_attendance_location')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        $employee = $this->employee_repository->getListParams();
        $attendanceLocation = $this->attendanceLocationRepository->getList();
        return view('employee_attendance_location.create', ['employee' => $employee, 'attendanceLocation' => $attendanceLocation]);
    }

    public function edit($id)
    {
        $attendanceLocation = $this->attendanceLocationRepository->getList();
        $employee_attendance_location = $this->employee_attendance_location_repository->show($id);
        return view('employee_attendance_location.edit', ['employee_attendance_location' => $employee_attendance_location, 'attendanceLocation' => $attendanceLocation]);
    }

    public function show($id)
    {
        $employee_attendance_location = $this->employee_attendance_location_repository->show($id);
        return view('employee_attendance_location.show', ['employee_attendance_location' => $employee_attendance_location]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'attendance_location_id',
            'employee_id',
            'start_date',
            'end_date',
        ]);

        $succesStatus = $this->employee_attendance_location_repository->update($id, $data);
        $this->log_repository->logActivity('Updated employee attendance location with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_attendance_location')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->employee_attendance_location_repository->delete($id);
        $this->log_repository->logActivity('Deleted employee attendance location with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_attendance_location')->with('success', 'Data updated successfully!');
    }
}
