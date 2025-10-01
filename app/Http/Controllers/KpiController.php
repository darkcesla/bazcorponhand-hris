<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeeRepository;

class KpiController extends Controller
{
    protected $employee_repository;

    public function __construct(EmployeeRepository $employee_repository)
    {
        $this->employee_repository = $employee_repository;
    }

    public function index()
    {
        $currentMonth = \Carbon\Carbon::now()->format('F');
        $performanceMetrics = [
            ['threshold' => 90, 'performance' => 'Excellent'],
            ['threshold' => 70, 'performance' => 'Good'],
            ['threshold' => 50, 'performance' => 'Fair'],
            ['threshold' => 30, 'performance' => 'Poor'],
        ];
        $employees = $this->employee_repository->kpi();
        foreach ($employees as $employee) {
            $present = ($employee->present*1.00/$employee->attendance)*100;
            $employee['performance'] = $this->calculatePerformance($performanceMetrics, $present);
        }
        return view('kpi.index', ['employees' => $employees, 'currentMonth' => $currentMonth]);
    }

    private function calculatePerformance($performanceMetrics, $present)
    {
        foreach ($performanceMetrics as $metric) {
            if ($present >= $metric['threshold']) {
                return $metric['performance'];
            }
        }
        return 'Poor';
    }
}
