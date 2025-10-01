<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\DeductionRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class DeductionController extends Controller
{
    protected $deduction_repository;
    protected $log_repository;
    protected $employee_repository;

    public function __construct(
        DeductionRepository $deduction_repository,
        LogRepository $log_repository,
        EmployeeRepository $employee_repository,
    ) {
        $this->deduction_repository = $deduction_repository;
        $this->log_repository = $log_repository;
        $this->employee_repository = $employee_repository;
    }

    public function index()
    {
        $params = [];
        if (session('selected_company')) {
            $params['company_id'] = session('selected_company');
        }
        $deductions = $this->deduction_repository->getList($params);
        return view('deduction.index', ['deductions' => $deductions]);
    }
    public function store(Request $request)
    {
        $data = $request->only([
            'employee_id',
            'amount',
            'description',
            'date',
        ]);
        $this->deduction_repository->create($data);
        $this->log_repository->logActivity('Created deduction', $request->ip());
        return redirect()->route('admin.deduction')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        $employees = $this->employee_repository->getListParams();
        return view('deduction.create', ['employees' => $employees]);
    }

    public function edit($id)
    {
        $deduction = $this->deduction_repository->show($id);
        return view('deduction.edit', ['deduction' => $deduction]);
    }

    public function show($id)
    {
        $deduction = $this->deduction_repository->show($id);
        return view('deduction.show', ['deduction' => $deduction]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'employee_id',
            'amount',
            'description',
            'date',
        ]);
        $succesStatus = $this->deduction_repository->update($id, $data);
        $this->log_repository->logActivity('Updated deduction with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.deduction')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->deduction_repository->delete($id);
        $this->log_repository->logActivity('Deleted deduction with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.deduction')->with('success', 'Data updated successfully!');
    }
}
