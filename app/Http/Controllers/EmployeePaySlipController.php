<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeePaySlipRepository;
use App\Repositories\EmployeePayrollRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\DeductionRepository;
use App\Repositories\EarningRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;

class EmployeePaySlipController extends Controller
{
    protected $employee_pay_slip_repository;
    protected $employee_payroll_repository;
    protected $employee_repository;
    protected $earning_repository;
    protected $deduction_repository;

    public function __construct(
        EmployeePaySlipRepository $employee_pay_slip_repository,
        EmployeePayrollRepository $employee_payroll_repository,
        EmployeeRepository $employee_repository,
        EarningRepository $earning_repository,
        DeductionRepository $deduction_repository
    ) {
        $this->employee_pay_slip_repository = $employee_pay_slip_repository;
        $this->employee_payroll_repository = $employee_payroll_repository;
        $this->employee_repository = $employee_repository;
        $this->earning_repository = $earning_repository;
        $this->deduction_repository = $deduction_repository;
    }

    public function index()
    {
        $currentDate = Carbon::now();
        $months = [];
        for ($month = 1; $month <= $currentDate->month; $month++) {
            $months[$month] = Carbon::createFromDate($currentDate->year, $month, 1)->format('F');
        }
        return view('employee_payslip.index', [
            'months' => $months
        ]);
    }

    public function show($id)
    {
        $employee_id = $this->employee_repository->getByUserId(auth()->user()->id)->id;
        $employee_payslip = $this->employee_payroll_repository->getEmployeePayroll($employee_id);

        $jht = $employee_payslip->basic_salary * 2 / 100;
        $pph21 = $employee_payslip->basic_salary * 5 / 100;
        $bpjs_kesehatan = $employee_payslip->basic_salary * 1 / 100;
        $jp = $employee_payslip->basic_salary * 1 / 100;
        $bpjs_kesehatan_company = $employee_payslip->basic_salary * 4 / 100;
        $jht_company = $employee_payslip->basic_salary * 3.7 / 100;;
        $jp_company = $employee_payslip->basic_salary * 2 / 100;;
        $earnings = [
            (object) ['name' => 'Basic Salary', 'amount' => $employee_payslip->basic_salary],
        ];

        $monthName = $id;
        $year = Carbon::now()->year;
        $monthNumber = Carbon::parse($monthName)->month;
        $params['year'] = $year;
        $params['month'] = $monthNumber;
        $params['employee_id'] = $employee_id;
        $monthDeductions = $this->deduction_repository->getList($params);
        $monthEarnings = $this->earning_repository->getList($params);
        $monthDeductionsFormatted = [];
        $monthEarningsFormatted = [];
        foreach ($monthDeductions as $deduction) {
            $monthDeductionsFormatted[] = (object) [
                'name' => $deduction->description,  // Assuming 'description' contains the name
                'amount' => $deduction->amount
            ];
        }
        foreach ($monthEarnings as $earning) {
            $monthEarningsFormatted[] = (object) [
                'name' => $earning->description,  // Assuming 'description' contains the name
                'amount' => $earning->amount
            ];
        }
        $deductions = [
            (object) ['name' => 'JHT', 'amount' => $jht],
            (object) ['name' => 'PPH 21', 'amount' => $pph21],
            (object) ['name' => 'BPJS Kesehatan', 'amount' => $bpjs_kesehatan],
            (object) ['name' => 'Jaminan Pensiun', 'amount' => $jp],
        ];
        $deductions = array_merge($deductions, $monthDeductionsFormatted);
        $earnings = array_merge($earnings, $monthEarningsFormatted);
        $benefits = [
            (object) ['name' => 'JHT', 'amount' => $jht_company],
            (object) ['name' => 'BPJS Kesehatan', 'amount' => $bpjs_kesehatan_company],
            (object) ['name' => 'Jaminan Pensiun', 'amount' => $jp_company],
        ];

        $totalAllowance = 0;
        $allowances = json_decode($employee_payslip->allowance, true);
        foreach ($allowances as $allowance) {
            $totalAllowance += $allowance['amount'];
            if ($allowance['amount'] > 0) {
                $earnings[] = (object) ['name' => $allowance['name'], 'amount' => $allowance['amount']];
            }
        }
        $maxLength = max(count($earnings), count($deductions));
        $totalEarnings = array_reduce($earnings, function ($carry, $item) {
            return $carry + $item->amount;
        }, 0);

        $totalDeductions = array_reduce($deductions, function ($carry, $item) {
            return $carry + $item->amount;
        }, 0);
        $totalBenefits = array_reduce($benefits, function ($carry, $item) {
            return $carry + $item->amount;
        }, 0);
        $netpay = $totalEarnings - $totalDeductions;
        return view('employee_payslip.detail', [
            'earnings' => $earnings,
            'deductions' => $deductions,
            'netpay' => $netpay,
            'maxLength' => $maxLength,
            'employee_payslip' => $employee_payslip,
            'totalEarnings' => $totalEarnings,
            'totalDeductions' => $totalDeductions,
            'benefits' => $benefits,
            'totalBenefits' => $totalBenefits,
        ]);
    }

    public function generatePdf()
    {
        $employee_id = $this->employee_repository->getByUserId(auth()->user()->id)->id;
        $employee_payslip = $this->employee_payroll_repository->getEmployeePayroll($employee_id);
        $jht = $employee_payslip->basic_salary * 2 / 100;
        $pph21 = $employee_payslip->basic_salary * 5 / 100;
        $bpjs_kesehatan = $employee_payslip->basic_salary * 1 / 100;
        $jp = $employee_payslip->basic_salary * 1 / 100;
        $bpjs_kesehatan_company = $employee_payslip->basic_salary * 4 / 100;
        $jht_company = $employee_payslip->basic_salary * 3.7 / 100;;
        $jp_company = $employee_payslip->basic_salary * 2 / 100;;
        $earnings = [
            (object) ['name' => 'Basic Salary', 'amount' => $employee_payslip->basic_salary],
        ];
        $deductions = [
            (object) ['name' => 'JHT', 'amount' => $jht],
            (object) ['name' => 'PPH 21', 'amount' => $pph21],
            (object) ['name' => 'BPJS Kesehatan', 'amount' => $bpjs_kesehatan],
            (object) ['name' => 'Jaminan Pensiun', 'amount' => $jp],
        ];
        $benefits = [
            (object) ['name' => 'JHT', 'amount' => $jht_company],
            (object) ['name' => 'BPJS Kesehatan', 'amount' => $bpjs_kesehatan_company],
            (object) ['name' => 'Jaminan Pensiun', 'amount' => $jp_company],
        ];

        $totalAllowance = 0;
        $allowances = json_decode($employee_payslip->allowance, true);
        foreach ($allowances as $allowance) {
            $totalAllowance += $allowance['amount'];
            if ($allowance['amount'] > 0) {
                $earnings[] = (object) ['name' => $allowance['name'], 'amount' => $allowance['amount']];
            }
        }
        $maxLength = max(count($earnings), count($deductions));
        $totalEarnings = array_reduce($earnings, function ($carry, $item) {
            return $carry + $item->amount;
        }, 0);

        $totalDeductions = array_reduce($deductions, function ($carry, $item) {
            return $carry + $item->amount;
        }, 0);
        $totalBenefits = array_reduce($benefits, function ($carry, $item) {
            return $carry + $item->amount;
        }, 0);
        $netpay = $totalEarnings - $totalDeductions;

        $path = public_path('logo_bazcorp.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $html = view('employee_payslip.document', [
            'earnings' => $earnings,
            'deductions' => $deductions,
            'netpay' => $netpay,
            'maxLength' => $maxLength,
            'employee_payslip' => $employee_payslip,
            'totalEarnings' => $totalEarnings,
            'totalDeductions' => $totalDeductions,
            'benefits' => $benefits,
            'totalBenefits' => $totalBenefits,
            'base64' => $base64,
        ])->render();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();

        $payslipName = 'payslip_' . $employee_payslip->id . '.pdf';
        return $dompdf->stream($payslipName, ['Attachment' => true]);
    }

    public function slipList()
    {
        try {
            $currentDate = Carbon::now();
            $months = [];
            for ($month = 1; $month <= $currentDate->month; $month++) {
                $months[] = ['id' => $month, 'month' => $month, 'year' => $currentDate->year, 'file' => 'https://bazcorponhand.com/public/storage/photo-user/payslip.pdf'];
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
        $filePath = 'photo-user/payslip.pdf';

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
            ->header('Content-Disposition', 'attachment; filename="payslip.pdf"');
    }
}
