<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\OvertimeRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use App\Exports\OvertimeExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\LogRepository;
use App\Repositories\UserRepository;
use App\Repositories\NotificationRepository;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;


class OvertimeController extends Controller
{
    protected $overtime_repository;
    protected $employee_repository;
    protected $log_repository;
    private $iteration = 0;
    protected $user_repository;
    protected $notification_repository;

    public function __construct(
        OvertimeRepository $overtime_repository,
        EmployeeRepository $employee_repository,
        LogRepository $log_repository,
        UserRepository $user_repository,
        NotificationRepository $notification_repository,
    ) {
        $this->overtime_repository = $overtime_repository;
        $this->employee_repository = $employee_repository;
        $this->log_repository = $log_repository;
        $this->user_repository = $user_repository;
        $this->notification_repository = $notification_repository;
    }
    public function index()
    {
        try {
            $params = [];
            if (session('selected_company') != 0) {
                $params['company_id'] = session('selected_company');
            }
            if (auth()->user()->role != 'admin') {
                $employee_id = $this->employee_repository->getByUserId(auth()->user()->id)->id;
                $params['employee_id'] = $employee_id;
            }
            $overtime = $this->overtime_repository->getList($params);
            return view('overtime.index', ['overtime' => $overtime]);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function slip_index()
    {
        $currentDate = Carbon::now();
        $months = [];
        for ($month = 1; $month <= $currentDate->month; $month++) {
            $months[$month] = Carbon::createFromDate($currentDate->year, $month, 1)->format('F');
        }
        return view('overtime.payslip.index', [
            'months' => $months
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->only([
                'employee_id',
                'date',
                'day_type',
                'start_time',
                'end_time',
                'total_hour',
                'description',
                'salary_per_hour',
                'total_salary'
            ]);
            if (auth()->user()->role != 'admin') {
                $employee_id = $this->employee_repository->getByUserId(auth()->user()->id)->id;
                $data['employee_id'] = $employee_id;
            }

            $overtime = $this->overtime_repository->create($data);
            $notifData = [
                'user_id' => 29,
                'title' => 'Overtime Edit Request',
                'description' => 'New overtime request',
                'url' =>  'https://bazcorponhand.com/public/admin/overtime/' . $overtime->id. '/show',
            ];
            $this->notification_repository->create($notifData);
            $this->log_repository->logActivity('Created overtime', $request->ip());
            return redirect()->route('admin.overtime')->with('success', 'Data updated successfully!');
        } catch (\Exception $e) {
            $this->log_repository->logActivity('Unhandled exception in overtime creation: ' . $e->getMessage(), $request->ip());
            return back()->withErrors($e->getMessage());
        }
    }

    public function create()
    {
        try {
            $employee = $this->employee_repository->getListParams();
            return view('overtime.create', ['employee' => $employee]);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $overtime = $this->overtime_repository->show($id);
            if ($overtime === null) {
                throw new \Exception("Overtime with id $id not found");
            }
            return view('overtime.edit', ['overtime' => $overtime]);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $overtime = $this->overtime_repository->show($id);
            if ($overtime === null) {
                throw new \Exception("Overtime with id $id not found");
            }
            return view('overtime.show', ['overtime' => $overtime]);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'employee_id',
            'date',
            'day_type',
            'start_time',
            'end_time',
            'total_hour',
            'description',
            'salary_per_hour',
            'total_salary',
        ]);
        $succesStatus = $this->overtime_repository->update($id, $data);
        $this->log_repository->logActivity('Updated overtime with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.overtime')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->overtime_repository->delete($id);
        $this->log_repository->logActivity('Deleted overtime with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.overtime')->with('success', 'Data updated successfully!');
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
            $result = $this->overtime_repository->getList($data);

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
            $validatedData = $request->validate([
                'attachment' => 'file|mimes:jpeg,png,jpg,gif,doc,docx,pdf',
            ]);
            $data = $request->only([
                'date',
                'start_time',
                'end_time',
                'description',
                'attachment',
            ]);
            if ($request->hasFile('attachment')) {
                $image = $request->file('attachment');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/photo-user', $imageName);
                $data['attachment'] = 'storage/photo-user/' . $imageName;
            }
            $data['employee_id'] = $employee->id;
            $overtime = $this->overtime_repository->create($data);
            $notifData = [
                'user_id' => 29,
                'title' => 'Overtime Request',
                'description' => 'New overtime request',
                'url' =>  'https://bazcorponhand.com/public/admin/overtime/' . $overtime->id. '/show',
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
                'date',
                'start_time',
                'end_time',
                'description',
                'attachment',
            ]);
            if ($request->hasFile('attachment')) {
                $image = $request->file('attachment');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/photo-user', $imageName);
                $data['attachment'] = 'storage/photo-user/' . $imageName;
            }
            if ($employee) {
                $response = [
                    'message' => 'Invalid token',
                    'data' => [],
                ];
                return response()->json($response, 401);
            }
            $overtime = $this->overtime_repository->update($id, $data);
            $notifData = [
                'user_id' => 29,
                'title' => 'Overtime Edit Request',
                'description' => 'New overtime request',
                'url' =>  'https://bazcorponhand.com/public/admin/overtime/' . $overtime->id. '/show',
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

    public function preview(Request $request)
    {
        try {
            $data = $request->only(['start_date', 'end_date', 'employee_ids']);
            if (session('selected_company') != 0) {
                $data['company_id'] = session('selected_company');
            }
            $result = $this->overtime_repository->getList($data);
            if ($result === null) {
                throw new \Exception('No data returned from overtime repository');
            }
            return view('overtime.preview', ['overtime' => $result]);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function export(Request $request)
    {
        $data = $request->only(['start_date', 'end_date']);
        if (session('selected_company') !== null && session('selected_company') != 0) {
            $data['company_id'] = session('selected_company');
        }
        try {
            $result = $this->overtime_repository->getList($data);
            if ($result === null) {
                throw new \Exception('No data returned from overtime repository');
            }
            $dataList = $result->map(function ($overtime) {
                if ($overtime->employee === null) {
                    $employeeName = '';
                } else {
                    $employeeName = $overtime->employee->firstname . ' ' . $overtime->employee->lastname . ' (' . $overtime->employee->employee_no . ')';
                }
                return [
                    'No.' => ++$this->iteration,
                    'Employee' => $employeeName,
                    'Date' => $overtime->date,
                    'Day Type' => $overtime->day_type,
                    'Start Time' => $overtime->start_time,
                    'End Time' => $overtime->end_time,
                    'Description' => $overtime->description,
                    'Total Hour' => $overtime->total_hour,
                    'Salary Per Hour' => $overtime->salary_per_hour,
                    'Total Salary' => $overtime->total_salary
                ];
            });
            $columns =  ['No.', 'Employee', 'Date', 'Day Type', 'Start Time', 'End Time', 'Description', 'Total Hour', 'Salary Per Hour', 'Total Salary'];
            $this->log_repository->logActivity('Export Overtime data', $request->ip());
            return Excel::download(new OvertimeExport($dataList, $columns), 'data.xlsx');
        } catch (\Exception $e) {
            $this->log_repository->logActivity('Unhandled exception in overtime export: ' . $e->getMessage(), '', $request->ip());
            return back()->withErrors($e->getMessage());
        }
    }

    public function slip_show($id)
    {
        $employee_id = $this->employee_repository->getByUserId(auth()->user()->id)->id;
        $monthNumber = Carbon::parse($id)->month;
        $month = $monthNumber;
        $year = Carbon::now()->year;
        $firstDayOfMonth = Carbon::createFromDate($year, $month, 1);
        $lastDayOfMonth = $firstDayOfMonth->copy()->endOfMonth();
        $params['start_date'] = $firstDayOfMonth;
        $params['end_date'] = $lastDayOfMonth;
        $params['employee_id'] = $employee_id;
        $overtimes = $this->overtime_repository->getList($params);
        $totalHour = 0;
        $totalSalary = 0;
        foreach ($overtimes as $overtime) {
            $totalHour += $overtime->total_hour;
            $totalSalary += $overtime->total_salary;
        }
        return view('overtime.payslip.detail', [
            'overtimes' => $overtimes[0],
            'totalHour' => $totalHour,
            'totalSalary' => $totalSalary,
            'month' => $month,
        ]);
    }

    public function generatePdf($id)
    {
        $employee_id = $this->employee_repository->getByUserId(auth()->user()->id)->id;
        $monthNumber = $id;
        $month = $monthNumber;
        $year = Carbon::now()->year;
        $firstDayOfMonth = Carbon::createFromDate($year, $month, 1);
        $lastDayOfMonth = $firstDayOfMonth->copy()->endOfMonth();
        $params['start_date'] = $firstDayOfMonth;
        $params['end_date'] = $lastDayOfMonth;
        $params['employee_id'] = $employee_id;
        $overtimes = $this->overtime_repository->getList($params);
        $totalHour = 0;
        $totalSalary = 0;
        foreach ($overtimes as $overtime) {
            $totalHour += $overtime->total_hour;
            $totalSalary += $overtime->total_salary;
        }

        $path = public_path('logo_bazcorp.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $html = view('overtime.payslip.document', [
            'overtimes' => $overtimes[0],
            'totalHour' => $totalHour,
            'totalSalary' => $totalSalary,
            'month' => $month,
            'base64'=>$base64,
        ])->render();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();

        $payslipName = 'payslip_' . $employee_id . '.pdf';
        return $dompdf->stream($payslipName, ['Attachment' => true]);
    }

    public function slipList()
    {
        try {
            $currentDate = Carbon::now();
            $months = [];
            for ($month = 1; $month <= $currentDate->month; $month++) {
                $months[] = ['id' => $month, 'month' => $month, 'year' => $currentDate->year, 'file' => 'https://bazcorponhand.com/public/storage/photo-user/overtime_payslip.pdf'];
            }
            $response = [
                'message' => 'success',
                'data' => $months
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

    public function download($id)
    {
        $filePath = 'photo-user/overtime_payslip.pdf';

        // Check if the file exists in the 'public' disk
        if (!Storage::disk('public')->exists($filePath)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        // Get the file content and MIME type
        $file = Storage::disk('public')->get($filePath);
        $mimeType = 'application/pdf';

        // Return the file with appropriate headers
        return response($file, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'attachment; filename="overtime_payslip.pdf"');
    }
}
