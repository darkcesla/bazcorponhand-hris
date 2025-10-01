<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\OvertimeSalaryRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class OvertimeSalaryController extends Controller
{
    protected $overtime_salary_repository;
    protected $log_repository;

    public function __construct(
        OvertimeSalaryRepository $overtime_salary_repository,
        LogRepository $log_repository
    ) {
        $this->overtime_salary_repository = $overtime_salary_repository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        $overtime_salary = $this->overtime_salary_repository->getList();
        return view('overtime_salary.index', ['overtime_salary' => $overtime_salary]);
    }
    public function store(Request $request)
    {
        $data = $request->only([
            'code',
            'company_id',
            'salary_per_hour'
        ]);
        $succesStatus = $this->overtime_salary_repository->create($data);
        $this->log_repository->logActivity('Created overtime salary', $request->ip());
        return redirect()->route('admin.overtime_salary')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        return view('overtime_salary.create');
    }

    public function edit($id)
    {
        $overtime_salary = $this->overtime_salary_repository->show($id);
        return view('overtime_salary.edit', ['overtime_salary' => $overtime_salary]);
    }

    public function show($id)
    {
        $overtime_salary = $this->overtime_salary_repository->show($id);
        return view('overtime_salary.show', ['overtime_salary' => $overtime_salary]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'code',
            'company_id',
            'salary_per_hour'
        ]);
        $succesStatus = $this->overtime_salary_repository->update($id, $data);
        $this->log_repository->logActivity('Updated overtime salary with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.overtime_salary')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->overtime_salary_repository->delete($id);
        $this->log_repository->logActivity('Deleted overtime salary with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.overtime_salary')->with('success', 'Data updated successfully!');
    }
}
