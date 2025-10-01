<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\AttendanceRepository;
use App\Repositories\AttendanceLocationRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\EmployeeShiftRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;
use Carbon\Carbon;
use App\Exports\OvertimeExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\UserRepository;
use App\Repositories\NotificationRepository;

class AttendanceController extends Controller
{
    protected $attendanceRepository;
    protected $attendanceLocationRepository;
    protected $employee_repository;
    protected $log_repository;
    private $iteration = 0;
    protected $user_repository;
    protected $employee_shift_repository;
    protected $notification_repository;

    public function __construct(
        AttendanceRepository $attendanceRepository,
        AttendanceLocationRepository $attendanceLocationRepository,
        EmployeeRepository $employee_repository,
        EmployeeShiftRepository $employee_shift_repository,
        LogRepository $log_repository,
        UserRepository $user_repository,
        NotificationRepository $notification_repository,
    ) {
        $this->attendanceRepository = $attendanceRepository;
        $this->attendanceLocationRepository = $attendanceLocationRepository;
        $this->employee_repository = $employee_repository;
        $this->employee_shift_repository = $employee_shift_repository;
        $this->log_repository = $log_repository;
        $this->user_repository = $user_repository;
        $this->notification_repository = $notification_repository;
    }

    public function index()
    {
        $params = [];
        $attendance = $this->attendanceRepository->getList($params);
        if (auth()->user()->role != 'admin') {
            $employee_id = $this->employee_repository->getByUserId(auth()->user()->id)->id;
            $attendance = $this->attendanceRepository->getListUser($employee_id);
        }
        return view('attendance.index', ['attendance' => $attendance]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->only([
                'employee_id',
                'shift_daily_id',
                'attendance_location_id',
                'check_in',
                'check_out',
                'check_in_longitude',
                'check_in_latitude',
                'check_out_longitude',
                'check_out_latitude',
                'date',
            ]);
            $data['status'] = 0;
            $data['date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['date']);
            $succesStatus = $this->attendanceRepository->create($data);
            $this->log_repository->logActivity('Created attendance', $request->ip());
            return redirect()->route('admin.attendance')->with('success', 'Data updated successfully!');
        } catch (\Exception $e) {
            report($e);
            return back()->withErrors([
                'message' => 'Error: ' . $e->getMessage(),
            ], 422);
        }
    }

    public function create()
    {
        try {
            $attendanceLocation = $this->attendanceLocationRepository->getList();
            if (is_null($attendanceLocation)) {
                throw new \RuntimeException('attendanceLocation is null');
            }
            $employee = $this->employee_repository->getListParams();
            if (is_null($employee)) {
                throw new \RuntimeException('employee is null');
            }
            return view('attendance.create', ['attendanceLocation' => $attendanceLocation, 'employee' => $employee]);
        } catch (\Exception $e) {
            report($e);
            return back()->withErrors([
                'message' => 'Error: ' . $e->getMessage(),
            ], 422);
        }
    }

    public function show($id)
    {
        $attendance = $this->attendanceRepository->show($id);
        return view('attendance.show', ['attendance' => $attendance]);
    }

    public function edit($id)
    {
        $attendanceLocation = $this->attendanceLocationRepository->getList();
        $attendance = $this->attendanceRepository->show($id);
        return view('attendance.edit', ['attendanceLocation' => $attendanceLocation, 'attendance' => $attendance]);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->only([
                'employee_id',
                'shift_daily_id',
                'attendance_location_id',
                'check_in',
                'check_out',
                'check_in_longitude',
                'check_in_latitude',
                'check_out_longitude',
                'check_out_latitude',
                'date',
                'status'
            ]);
            $data['date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['date']);
            $succesStatus = $this->attendanceRepository->update($id, $data);
            $this->log_repository->logActivity('Updated attendance with id: ' . $id, '', $request->ip());
            return redirect()->route('admin.attendance')->with('success', 'Data updated successfully!');
        } catch (\Exception $e) {
            report($e);
            return back()->withErrors([
                'message' => 'Error: ' . $e->getMessage(),
            ], 422);
        }
    }

    public function getCurrent()
    {
        $employee_id = $this->employee_repository->getByUserId(auth()->user()->id)->id;
        $attendance = $this->attendanceRepository->current($employee_id);
        return view('attendance.current', ['attendance' => $attendance]);
    }

    public function checkin($id)
    {
        $attendanceLocation = $this->attendanceLocationRepository->getList();
        $attendance = $this->attendanceRepository->show($id);
        return view('attendance.check_in', ['attendanceLocation' => $attendanceLocation, 'attendance' => $attendance]);
    }

    public function checkin_process(Request $request, $id)
    {
        try {
            $attendance = $this->attendanceRepository->show($id);
            if (is_null($attendance)) {
                throw new \DomainException('Attendance not found');
            }

            $data = $request->only([
                'check_in_longitude',
                'check_in_latitude',
                'check_in_image'
            ]);

            if (empty($data['check_in_longitude']) || empty($data['check_in_latitude'])) {
                throw new \InvalidArgumentException('Check in latitude and longitude is required');
            }

            $data['check_in'] = Carbon::now();
            $succesStatus = $this->attendanceRepository->update($id, $data);
            $this->log_repository->logActivity('Check in attendance with id: ' . $id, '', $request->ip());
            return redirect()->route('attendance.current')->with('success', 'Data updated successfully!');
        } catch (\Exception $e) {
            report($e);
            return back()->withErrors([
                'message' => 'Error: ' . $e->getMessage(),
            ], 422);
        }
    }

    public function checkout($id)
    {
        $attendanceLocation = $this->attendanceLocationRepository->getList();
        $attendance = $this->attendanceRepository->show($id);
        return view('attendance.check_out', ['attendanceLocation' => $attendanceLocation, 'attendance' => $attendance]);
    }

    public function checkout_process(Request $request, $id)
    {
        try {
            $attendance = $this->attendanceRepository->show($id);
            if (is_null($attendance)) {
                throw new \DomainException('Attendance not found');
            }

            $data = $request->only([
                'check_out_longitude',
                'check_out_latitude',
                'check_out_image'
            ]);

            if (empty($data['check_out_longitude']) || empty($data['check_out_latitude'])) {
                throw new \InvalidArgumentException('Check out latitude and longitude is required');
            }

            $data['check_out'] = Carbon::now();
            $data['status'] = 1; // assuming this is the status for checked out

            $succesStatus = $this->attendanceRepository->update($id, $data);

            $this->log_repository->logActivity('Checkout attendance with id: ' . $id, '', $request->ip());

            return redirect()->route('attendance.current')->with('success', 'Data updated successfully!');
        } catch (\Exception $e) {
            report($e);
            return back()->withErrors([
                'message' => 'Error: ' . $e->getMessage(),
            ], 422);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $attendance = $this->attendanceRepository->show($id);
            if (is_null($attendance)) {
                throw new \DomainException('Attendance not found');
            }
            $succesStatus = $this->attendanceRepository->delete($id);
            $this->log_repository->logActivity('Deleted attendance with id: ' . $id, '', $request->ip());
            return redirect()->route('admin.attendance')->with('success', 'Data updated successfully!');
        } catch (\Exception $e) {
            report($e);
            return back()->withErrors([
                'message' => 'Error: ' . $e->getMessage(),
            ], 422);
        }
    }

    //API
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
            $data = $request->only(['start_date', 'end_date', 'page', 'per_page']);
            $data['employee_id'] = $employee->id;
            $attendance = $this->attendanceRepository->getList($data);
            if (empty($attendance)) {
                return response()
                    ->json(['message' => 'No data found', 'data' => null], 404);
            }
            $nextPageUrl = $attendance->nextPageUrl();
            $previousPageUrl = $attendance->previousPageUrl();
            $total = $attendance->total();
            $perPage = $attendance->perPage();
            $currentPage = $attendance->currentPage();
            $lastPage = $attendance->lastPage();
            $response = [
                'message' => 'success',
                'data' => $attendance->items(),
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


    public function checkInApi(Request $request, int $id)
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
            $validatedData = $request->validate([
                'check_in_longitude' => 'required|numeric',
                'check_in_latitude' => 'required|numeric',
                'check_in_image' => 'required|file|mimes:jpeg,png,jpg,gif',
            ]);
            $data = $request->only([
                'check_in_longitude',
                'check_in_latitude',
                'check_in_image'
            ]);
            if ($request->hasFile('check_in_image')) {
                $image = $request->file('check_in_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/photo-user', $imageName);
                $data['check_in_image'] = 'storage/photo-user/' . $imageName;
            }
            $data['employee_id'] = $employee->id;
            $data['check_in'] = Carbon::now('Asia/Jakarta');;
            $this->attendanceRepository->update($id, $data);

            $response = [
                'message' => 'success',
                'data' => [],
            ];
            return response()->json($response, 201);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function checkOutApi(Request $request, int $id)
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
            $data = $request->only([
                'check_out_longitude',
                'check_out_latitude',
                'check_out_image'
            ]);
            if ($request->hasFile('check_out_image')) {
                $image = $request->file('check_out_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/photo-user', $imageName);
                $data['check_out_image'] = 'storage/photo-user/' . $imageName;
            }
            $data['employee_id'] = $employee->id;
            $data['check_out'] = Carbon::now('Asia/Jakarta');;
            $this->attendanceRepository->update($id, $data);

            $response = [
                'message' => 'success',
                'data' => [],
            ];
            return response()->json($response, 201);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function put(Request $request, int $id)
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
            $data = $request->only([
                'check_out',
                'check_in',
            ]);
            $data['employee_id'] = $employee->id;
            $attendance = $this->attendanceRepository->update($id, $data);
            $notifData = [
                'user_id' => 1,
                'title' => 'Attendance Edit Request',
                'description' => $employee->firstname . ' ' . $employee->lastname . ' attendance edit request',
                'url' =>  'https://bazcorponhand.com/public/admin/attendance/' . $attendance . '/show',
            ];
            $this->notification_repository->create($notifData);
            $response = [
                'message' => 'success',
                'data' => [],
            ];
            return response()->json($response, 201);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function currentShift(Request $request)
    {
        try {
            $token = $request->header('token');
            if (empty($token)) {
                return response()
                    ->json(['message' => 'Token not provided', 'data' => null], 401);
            }
            $employee = $this->user_repository->checkToken($token);
            $employee_id = $employee->id;
            $attendance = $this->attendanceRepository->current($employee_id);
            $response = [
                'message' => 'success',
                'data' => $attendance
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = [
                'message' => 'An error occurred, please try again later',
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ],
            ];
            return response()->json($response, 500);
        }
    }

    public function monthlyShift(Request $request)
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
            $data['page'] = 1;
            $data['per_page'] = 100;
            $data['employee_id'] = $employee->id;
            $data['start_date'] = Carbon::now()->startOfMonth()->format('Y-m-d');
            $data['end_date'] = Carbon::now()->endOfMonth()->format('Y-m-d');
            $attendance = $this->attendanceRepository->getList($data);
            if (empty($attendance)) {
                return response()
                    ->json(['message' => 'No data found', 'data' => null], 404);
            }
            $nextPageUrl = $attendance->nextPageUrl();
            $previousPageUrl = $attendance->previousPageUrl();
            $total = $attendance->total();
            $perPage = $attendance->perPage();
            $currentPage = $attendance->currentPage();
            $lastPage = $attendance->lastPage();
            $response = [
                'message' => 'success',
                'data' => $attendance->items(),
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


    public function report(Request $request)
    {
        $employees = $this->employee_repository->getListParams();
        return view('attendance.report', ['employees' => $employees]);
    }

    public function report_process(Request $request)
    {

        $data = $request->only(['start_date', 'end_date', 'status', 'employee_ids']);
        if (session('selected_company') !== null && session('selected_company') != 0) {
            $data['company_id'] = session('selected_company');
        }
        $data['off_status'] = 1;
        $data['employee_ids'] = $request->input('chosen_employees');
        try {
            $result = $this->attendanceRepository->getList($data);
            if ($result === null) {
                throw new \Exception('No data returned from overtime repository');
            }
            $dataList = collect($result)->map(function ($attendance) {
                if ($attendance->employee === null) {
                    $employeeName = '';
                } else {
                    $employeeName = $attendance->employee->firstname . ' ' . $attendance->employee->lastname . ' (' . $attendance->employee->employee_no . ')';
                }
                $status = '';
                switch ($attendance->status) {
                    case 1:
                        $status = 'Present';
                        break;
                    case 2:
                        $status = 'Late';
                        break;
                    case 3:
                        $status = 'Absent';
                        break;
                    case 4:
                        $status = 'Late';
                        break;
                    case 5:
                        $status = 'Sick';
                        break;
                    case 6:
                        $status = 'Permission';
                        break;
                    default:
                        $status = 'Pending';
                }
                $attendanceData = [
                    'No.' => ++$this->iteration,
                    'Employee' => $employeeName,
                    'Date' => $attendance->date,
                    'Shift' => $attendance->shift_daily->shift_daily_code,
                    'Shift In' => $attendance->shift_daily->start_time,
                    'Shift Out' => $attendance->shift_daily->end_time,
                    'Check In' => $attendance->check_in,
                    'Check In Diff' => $attendance->in_diff == 0 && $attendance->check_in != null ? '0' : $attendance->in_diff,
                    'Check Out' => $attendance->check_out,
                    'Check Out Diff' => $attendance->out_diff == 0 && $attendance->check_out != null ? '0' : $attendance->out_diff,
                    'Break Start' => $attendance->break_start,
                    'Break End' => $attendance->break_end,
                    'Title' => $attendance->title,
                    'Tax' => ($attendance->tax_flag == 1) ? 'yes' : 'no',
                    'Status' => $status,
                ];
                return $attendanceData;
            });
            $columns = array_keys($dataList->first());
            $this->log_repository->logActivity('Export attendance data', $request->ip());
            return Excel::download(new OvertimeExport($dataList, $columns), 'data.xlsx');
        } catch (\Exception $e) {
            $this->log_repository->logActivity('Unhandled exception in attendance export: ' . $e->getMessage(), '', $request->ip());
            return back()->withErrors($e->getMessage());
        }
    }
}
