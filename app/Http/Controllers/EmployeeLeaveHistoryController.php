<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeeLeaveHistoryRepository;
use App\Repositories\LeaveTypeRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;
use App\Repositories\UserRepository;
use App\Repositories\NotificationRepository;

class EmployeeLeaveHistoryController extends Controller
{
    protected $employee_leave_history_repository;
    protected $leaveTypeRepository;
    protected $employee_repository;
    protected $log_repository;
    protected $user_repository;
    protected $notification_repository;


    public function __construct(
        EmployeeLeaveHistoryRepository $employee_leave_history_repository,
        EmployeeRepository $employee_repository,
        LeaveTypeRepository $leaveTypeRepository,
        LogRepository $log_repository,
        UserRepository $user_repository,
        NotificationRepository $notification_repository,
    ) {
        $this->employee_leave_history_repository = $employee_leave_history_repository;
        $this->leaveTypeRepository = $leaveTypeRepository;
        $this->employee_repository = $employee_repository;
        $this->log_repository = $log_repository;
        $this->user_repository = $user_repository;
        $this->notification_repository = $notification_repository;
    }

    public function index()
    {
        $params = [];
        if (auth()->user()->role != 'admin') {
            $employee_id = $this->employee_repository->getByUserId(auth()->user()->id)->id;
            $params['employee_id'] = $employee_id;
        }
        $employee_leave_history = $this->employee_leave_history_repository->getList($params);
        return view('employee_leave_history.index', ['employee_leave_history' => $employee_leave_history]);
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'leave_type_id',
            'employee_id',
            'start_date',
            'end_date',
            'day_count',
            'notes',
        ]);
        $employee = $this->employee_repository->getByUserId(auth()->user()->id);
        $data['employee_id'] = $employee->id;
        $data['approval_status'] = "Pending";
        $succesStatus = $this->employee_leave_history_repository->create($data);
        $notifData = [
            'user_id' => 1,
            'title' => 'Leave Request',
            'description' => $employee->firstname . ' ' . $employee->lastname .' create leave request',
            'url' =>  'https://bazcorponhand.com/public/admin/employee-leave-history/' . $succesStatus->id,
        ];
        $this->notification_repository->create($notifData);
        $this->log_repository->logActivity('Created employee leave history', $request->ip());
        return redirect()->route('admin.employee_leave_history')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        $employee = $this->employee_repository->getListParams();
        $leave_type = $this->leaveTypeRepository->getList();
        return view('employee_leave_history.create', ['employee' => $employee, 'leave_type' => $leave_type]);
    }

    public function edit($id)
    {
        $leave_type = $this->leaveTypeRepository->getList();
        $employee_leave_history = $this->employee_leave_history_repository->show($id);
        return view('employee_leave_history.edit', ['employee_leave_history' => $employee_leave_history, 'leave_type' => $leave_type]);
    }

    public function show($id)
    {
        $employee_leave_history = $this->employee_leave_history_repository->show($id);
        return view('employee_leave_history.show', ['employee_leave_history' => $employee_leave_history]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'leave_type_id',
            'employee_id',
            'start_date',
            'end_date',
            'day_count',
            'superior_approval',
            'hr_approval',
            'approval_status',
            'notes',
        ]);
        $succesStatus = $this->employee_leave_history_repository->update($id, $data);
        $this->log_repository->logActivity('Updated employee leave history with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_leave_history')->with('success', 'Data updated successfully!');
    }

    public function approve($id)
    {
        $this->employee_leave_history_repository->approve($id);
        return redirect()->route('admin.employee_leave_history')->with('success', 'Employee approved successfully.');
    }


    public function reject(Request $request,$id)
    {
        $data = $request->only([
            'reject_note'
        ]);
        $data['approval_status'] = 'rejected';
        $this->employee_leave_history_repository->update($id,$data);
        return redirect()->route('admin.employee_leave_history')->with('successStatus');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->employee_leave_history_repository->delete($id);
        $this->log_repository->logActivity('Deleted employee leave history with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_leave_history')->with('success', 'Data updated successfully!');
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

            $data = $request->only(['start_date', 'end_date', 'page', 'per_page']);
            $data['employee_id'] = $employee->id;
            $result = $this->employee_leave_history_repository->getList($data);

            if (empty($result)) {
                return response()
                    ->json(['message' => 'No data found', 'data' => null], 404);
            }
            $nextPageUrl = $result->nextPageUrl();
            $previousPageUrl = $result->previousPageUrl();
            $total = $result->total();
            $perPage = $result->perPage();
            $currentPage = $result->currentPage();
            $lastPage = $result->lastPage();
            $response = [
                'message' => 'success',
                'data' => $result->items(),
                'next_page_url' => $nextPageUrl,
                'previous_page_url' => $previousPageUrl,
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $currentPage,
                'last_page' => $lastPage,
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

    public  function post(Request $request)
    {
        $token = $request->header('token');
        if (empty($token)) {
            return response()
                ->json(['message' => 'Token not provided', 'data' => null], 401);
        }
        try {
            $employee = $this->user_repository->checkToken($token);
            $data = $request->only([
                'leave_type_id',
                'start_date',
                'end_date',
                'notes',
            ]);
            $data['employee_id'] = $employee->id;
            $data['approval_status'] = 'requested';
            $data['user_id'] = $employee->user_id;
            $overtime = $this->employee_leave_history_repository->create($data);
            //$this->log_repository->logActivity('Created overtime', $request->ip());
            $notifData = [
                'user_id' => 29,
                'title' => 'Leave Request',
                'description' => $employee->firstname . ' ' . $employee->lastname .' create leave request',
                'url' =>  'https://bazcorponhand.com/public/admin/employee-leave-history/' . $overtime->id . '/show',
            ];
            $this->notification_repository->create($notifData);
            $response = [
                'message' => 'success',
                'data' => $overtime
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

    public  function put(Request $request, int $id)
    {
        $token = $request->header('token');
        if (empty($token)) {
            return response()
                ->json(['message' => 'Token not provided', 'data' => null], 401);
        }
        try {
            $employee = $this->user_repository->checkToken($token);
            $data = $request->only([
                'leave_type_id',
                'start_date',
                'end_date',
                'notes',
            ]);
            if($employee){
                $response = [
                    'message' => 'Invalid token',
                    'data' => [],
                ];
                return response()->json($response, 401);
            }
            $overtime = $this->employee_leave_history_repository->update($id, $data);
            $notifData = [
                'user_id' => 29,
                'title' => 'Leave Request',
                'description' => $employee->firstname . ' ' . $employee->lastname .' create leave request',
                'url' =>  'https://bazcorponhand.com/public/admin/employee-leave-history/' . $overtime->id . '/show',
            ];
            $this->notification_repository->create($notifData);
            $response = [
                'message' => 'success',
                'data' => $overtime
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
}
