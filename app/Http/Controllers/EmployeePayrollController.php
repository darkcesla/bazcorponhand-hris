<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\AllowanceTypeRepository;
use App\Repositories\EmployeePayrollRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\OvertimeExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\LogRepository;

class EmployeePayrollController extends Controller
{
    protected $employee_payroll_repository;
    protected $employee_repository;
    protected $allowance_type_repository;
    protected $log_repository;
    private $iteration = 0;

    public function __construct(
        AllowanceTypeRepository $allowance_type_repository,
        EmployeePayrollRepository $employee_payroll_repository,
        EmployeeRepository $employee_repository,
        LogRepository $log_repository
    ) {
        $this->employee_payroll_repository = $employee_payroll_repository;
        $this->employee_repository = $employee_repository;
        $this->log_repository = $log_repository;
        $this->allowance_type_repository = $allowance_type_repository;
    }

    public function index()
    {
        $employee_payroll = $this->employee_payroll_repository->getList();
        return view('employee_payroll.index', ['employee_payroll' => $employee_payroll]);
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'employee_id',
            'effective_salary_date',
            'title',
            'tax_flag',
            'salary_received',
            'basic_salary',
            'allowance',
            'total_allowance',
            'bpjs_ketenagakerjaan',
            'bpjs_kesehatan',
            'insurance',
            'insurance_number',
            'tax_number',
            'tax_type',
            'pay_frequency'
        ]);
        $data['total_allowance'] = 0;
        $data['pay_frequency'] = 'Monthly';
        $allowances = $request->input('allowances', []);
        $allowancesJson = json_encode($allowances);
        foreach ($allowances as $allowance) {
            $data['total_allowance'] += $allowance['amount'];
        }
        $data['allowance'] = $allowancesJson;
        $succesStatus = $this->employee_payroll_repository->create($data);
        $this->log_repository->logActivity('Created employee payroll', $request->ip());
        return redirect()->route('admin.employee_payroll')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        $allowanceTypes = $this->allowance_type_repository->getList();
        $employee = $this->employee_repository->getListParams();
        return view('employee_payroll.create', ['employee' => $employee, 'allowanceTypes' => $allowanceTypes]);
    }

    public function edit($id)
    {
        $employee_payroll = $this->employee_payroll_repository->show($id);
        $allowances = json_decode($employee_payroll->allowance, true);
        return view('employee_payroll.edit', ['employee_payroll' => $employee_payroll, 'allowances' => $allowances]);
    }

    public function show($id)
    {
        $employee_payroll = $this->employee_payroll_repository->show($id);
        $allowances = json_decode($employee_payroll->allowance, true);
        return view('employee_payroll.show', [
            'employee_payroll' => $employee_payroll,
            'allowances' => $allowances
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'employee_id',
            'effective_salary_date',
            'title',
            'tax_flag',
            'salary_received',
            'basic_salary',
            'allowance',
            'total_allowance',
            'bpjs_ketenagakerjaan',
            'bpjs_kesehatan',
            'insurance',
            'insurance_number',
            'tax_number',
            'tax_type',
            'pay_frequency'
        ]);

        $data['total_allowance'] = 0;
        $data['pay_frequency'] = 'Monthly';
        $allowances = $request->input('allowances', []);
        $allowancesJson = json_encode($allowances);
        foreach ($allowances as $allowance) {
            $data['total_allowance'] += $allowance['amount'];
        }
        $data['allowance'] = $allowancesJson;
        $succesStatus = $this->employee_payroll_repository->update($id, $data);
        $this->log_repository->logActivity('Updated employee payroll with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_payroll')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->employee_payroll_repository->delete($id);
        $this->log_repository->logActivity('Deleted employee payroll with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_payroll')->with('success', 'Data updated successfully!');
    }

    public function preview(Request $request)
    {
        $data = $request->only(['start_date', 'end_date']);

        if (!isset($data['start_date']) || !$data['start_date']) {
            $data['start_date'] = Carbon::now()->startOfMonth()->toDateString();
        }

        if (!isset($data['end_date']) || !$data['end_date']) {
            $data['end_date'] = Carbon::now()->endOfMonth()->toDateString();
        }

        $payroll = $this->employee_payroll_repository->getPreview($data);

        return view('overtime.preview', ['overtime' => $payroll]);
    }

    public function export(Request $request)
    {
        $data = [];
        if (session('selected_company') !== null && session('selected_company') != 0) {
            $data['company_id'] = session('selected_company');
        }
        try {
            $result = $this->employee_payroll_repository->getList($data);
            if ($result === null) {
                throw new \Exception('No data returned from overtime repository');
            }
            $dataList = collect($result)->map(function ($payroll) {
                if ($payroll->employee === null) {
                    $employeeName = '';
                } else {
                    $employeeName = $payroll->employee->firstname . ' ' . $payroll->employee->lastname . ' (' . $payroll->employee->employee_no . ')';
                }
                $allowances = json_decode($payroll->allowance, true);
                $extractedAllowances = [];
                foreach ($allowances as $allowance) {
                    $extractedAllowances[$allowance['name']] = $allowance['amount'];
                }
                foreach ($extractedAllowances as $allowanceType => $allowanceAmount) {
                    $payroll[$allowanceType] = $allowanceAmount;
                }
                $payrollData = [
                    'No.' => ++$this->iteration,
                    'Employee' => $employeeName,
                    'Salary Date' => $payroll->effective_salary_date,
                    'Title' => $payroll->title,
                    'Tax' => ($payroll->tax_flag == 1) ? 'yes' : 'no',
                    'Tax Type' => $payroll->tax_type,
                    'Salary Received' => $payroll->salary_received,
                    'Basic Salary' => $payroll->basic_salary,
                    'Total Allowance' => $payroll->total_allowance,
                    'BPJS TK' => $payroll->bpjs_ketenagakerjaan,
                    'BPJS Kesehatan' => $payroll->bpjs_kesehatan,
                    'Private Insurance' => $payroll->insurance,
                    'Insurance Number' => $payroll->insurance_number,
                ];
                $payrollData = array_merge($payrollData, $extractedAllowances);
                return $payrollData;
            });
            $columns = array_keys($dataList->first());
            $this->log_repository->logActivity('Export payroll data', $request->ip());
            return Excel::download(new OvertimeExport($dataList, $columns), 'data.xlsx');
        } catch (\Exception $e) {
            $this->log_repository->logActivity('Unhandled exception in payroll export: ' . $e->getMessage(), '', $request->ip());
            return back()->withErrors($e->getMessage());
        }
    }
}
