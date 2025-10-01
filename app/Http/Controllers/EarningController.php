<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\EarningRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class EarningController extends Controller
{
    protected $earning_repository;
    protected $log_repository;
    protected $employee_repository;

    public function __construct(
        EarningRepository $earning_repository,
        LogRepository $log_repository,
        EmployeeRepository $employee_repository,
    ) {
        $this->earning_repository = $earning_repository;
        $this->log_repository = $log_repository;
        $this->employee_repository = $employee_repository;
    }

    public function index()
    {
        $params = [];
        if (session('selected_company')) {
            $params['company_id'] = session('selected_company');
        }
        $earnings = $this->earning_repository->getList($params);
        return view('earning.index', ['earnings' => $earnings]);
    }
    public function store(Request $request)
    {
        $data = $request->only([
            'employee_id',
            'amount',
            'description',
            'date',
        ]);
        $this->earning_repository->create($data);
        $this->log_repository->logActivity('Created earning', $request->ip());
        return redirect()->route('admin.earning')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        $employees = $this->employee_repository->getListParams();
        return view('earning.create', ['employees' => $employees]);
    }

    public function edit($id)
    {
        $earning = $this->earning_repository->show($id);
        return view('earning.edit', ['earning' => $earning]);
    }

    public function show($id)
    {
        $earning = $this->earning_repository->show($id);
        return view('earning.show', ['earning' => $earning]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'employee_id',
            'amount',
            'description',
            'date',
        ]);
        $succesStatus = $this->earning_repository->update($id, $data);
        $this->log_repository->logActivity('Updated earning with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.earning')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->earning_repository->delete($id);
        $this->log_repository->logActivity('Deleted earning with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.earning')->with('success', 'Data updated successfully!');
    }
}
