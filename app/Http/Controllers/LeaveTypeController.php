<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\LeaveTypeRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class LeaveTypeController extends Controller
{

    protected $leaveTypeRepository;
    protected $log_repository;

    public function __construct(
        LeaveTypeRepository $leaveTypeRepository,
        LogRepository $log_repository
    ) {
        $this->leaveTypeRepository = $leaveTypeRepository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        $leave_type = $this->leaveTypeRepository->getList();
        return view('leave_type.index', ['leave_type' => $leave_type]);
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'leave_code',
            'leave_name',
            'eligibility_leave',
            'limit_date',
            'deducted_leave',
            'day_count',
            'leave_day_type',
            'validate_attendance_status',
            'once_in_employment_period',
            'once_in_balance_period',
            'balance_period_limit',
            'leave_period_base_on',
        ]);

        $succesStatus = $this->leaveTypeRepository->create($data);
        $this->log_repository->logActivity('Created leave type', $request->ip());

        return redirect()->route('admin.leave_type')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        return view('leave_type.create');
    }

    public function edit($id)
    {
        $leave_type = $this->leaveTypeRepository->show($id);
        return view('leave_type.edit', ['leave_type' => $leave_type]);
    }

    public function show($id)
    {
        $leave_type = $this->leaveTypeRepository->show($id);
        return view('leave_type.show', ['leave_type' => $leave_type]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'leave_code',
            'leave_name',
            'eligibility_leave',
            'limit_date',
            'deducted_leave',
            'day_count',
            'leave_day_type',
            'validate_attendance_status',
            'once_in_employment_period',
            'once_in_balance_period',
            'balance_period_limit',
            'leave_period_base_on',
        ]);
        $succesStatus = $this->leaveTypeRepository->update($id, $data);
        $this->log_repository->logActivity('Updated leave type with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.leave_type')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->leaveTypeRepository->delete($id);
        $this->log_repository->logActivity('Deleted leave type with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.leave_type')->with('success', 'Data updated successfully!');
    }

    public function get(Request $request)
    {
        try {
            $leave_type = $this->leaveTypeRepository->getList();
            if (empty($leave_type)) {
                return response()
                    ->json(['message' => 'No data found', 'data' => null], 404);
            }
            $response = [
                'message' => 'success',
                'data' => $leave_type,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
