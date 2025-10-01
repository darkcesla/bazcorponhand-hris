<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeeCareerRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class EmployeeCareerController extends Controller
{
    protected $employee_career_repository;
    protected $employee_repository;
    protected $log_repository;

    public function __construct(
        EmployeeCareerRepository $employee_career_repository,
        LogRepository $log_repository,
        EmployeeRepository $employee_repository
    ) {
        $this->employee_career_repository = $employee_career_repository;
        $this->employee_repository = $employee_repository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        $params = [];
        $employee_career = $this->employee_career_repository->getList($params);
        return view('employee_career.index', ['employee_career' => $employee_career]);
    }
    public function store(Request $request)
    {
        $file = $request->file('file');
        $data = $request->only([
            'transition_number',
            'employee_id',
            'letter',
            'transition_type',
            'join_date',
            'employment_type',
            'termination_type',
            'date',
            'start_date',
            'end_date',
            'position',
            'department'
        ]);
        $path = $file->store('public');
        $data['letter'] = $path;
        $career = $this->employee_career_repository->create($data);
        $this->log_repository->logActivity('Created employee career', $request->ip());
        return redirect()->route('admin.employee_career')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        $employee = $this->employee_repository->getListParams();
        return view('employee_career.create', ['employee' => $employee]);
    }

    public function edit($id)
    {
        $employee_career = $this->employee_career_repository->show($id);
        return view('employee_career.edit', ['employee_career' => $employee_career]);
    }

    public function show($id)
    {
        $employee_career = $this->employee_career_repository->show($id);
        return view('employee_career.show', ['employee_career' => $employee_career]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'transition_number',
            'employee_id',
            'letter',
            'transition_type',
            'join_date',
            'employment_type',
            'termination_type',
            'date',
            'start_date',
            'end_date',
            'position',
            'department'
        ]);
        $file = $request->file('file');
        if ($file) {
            $path = $file->store('public');
            $data['letter'] = $path;
        }
        $career = $this->employee_career_repository->update($id, $data);
        $this->log_repository->logActivity('Updated employee career with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_career')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $career = $this->employee_career_repository->delete($id);
        $this->log_repository->logActivity('Deleted employee career with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee_career')->with('success', 'Data updated successfully!');
    }
}
