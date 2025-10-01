<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeeBankAccountRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class EmployeeBankAccountController extends Controller
{
    protected $employee_bank_account_repository;
    protected $employee_repository;
    protected $log_repository;


    public function __construct(
        EmployeeBankAccountRepository $employee_bank_account_repository,
        EmployeeRepository $employee_repository,
        LogRepository $log_repository
    ) {
        $this->employee_bank_account_repository = $employee_bank_account_repository;
        $this->employee_repository = $employee_repository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        $employee_bank_account = $this->employee_bank_account_repository->getList();
        return view('employee_bank_account.index', ['employee_bank_account' => $employee_bank_account]);
    }
    public function store(Request $request)
    {
        $data = $request->only([
            'employee_id',
            'bank_name',
            'bank_branch',
            'bank_account',
            'account_name',
        ]);
        $succesStatus = $this->employee_bank_account_repository->create($data);
        $this->log_repository->logActivity('Created attendance', $request->ip());
        return redirect()->route('admin.employee_bank_account')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        $employee = $this->employee_repository->getListParams();
        return view('employee_bank_account.create', ['employee' => $employee]);
    }

    public function edit($id)
    {
        $employee_bank_account = $this->employee_bank_account_repository->show($id);
        return view('employee_bank_account.edit', ['employee_bank_account' => $employee_bank_account]);
    }

    public function show($id)
    {
        $employee_bank_account = $this->employee_bank_account_repository->show($id);
        return view('employee_bank_account.show', ['employee_bank_account' => $employee_bank_account]);
    }

    public function update(Request $request, $id)
    {

        $data = $request->only([
            'bank_name',
            'bank_branch',
            'bank_account',
            'account_name',
        ]);
        $succesStatus = $this->employee_bank_account_repository->update($id, $data);
        $this->log_repository->logActivity('Updated attendance with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_bank_account')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->employee_bank_account_repository->delete($id);
        $this->log_repository->logActivity('Deleted attendance with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_bank_account')->with('success', 'Data updated successfully!');
    }
}
