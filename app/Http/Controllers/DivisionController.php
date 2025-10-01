<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\DivisionRepository;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class DivisionController extends Controller
{
    protected $division_repository;
    protected $company_repository;
    protected $log_repository;

    public function __construct(
        DivisionRepository $division_repository,
        CompanyRepository $company_repository,
        LogRepository $log_repository
    ) {
        $this->division_repository = $division_repository;
        $this->company_repository = $company_repository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        $params = [];
        if (session('selected_company')) {
            $params['company_id'] = session('selected_company');
        }
        $divisions = $this->division_repository->getList($params);
        return view('division.index', ['division' => $divisions]);
    }
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'company_id',
        ]);
        $this->division_repository->create($data);
        $this->log_repository->logActivity('Created division', $request->ip());
        return redirect()->route('admin.division')->with('success', 'Data inserted successfully!');
    }

    public function create()
    {
        $company = $this->company_repository->getList();
        return view('division.create', ['company' => $company]);
    }

    public function edit($id)
    {
        $company = $this->company_repository->getList();
        $division = $this->division_repository->show($id);
        return view('division.edit', ['division' => $division, 'company' => $company]);
    }

    public function show($id)
    {
        $division = $this->division_repository->show($id);
        return view('division.show', ['division' => $division]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'name',
            'company_id',
        ]);
        $succesStatus = $this->division_repository->update($id, $data);
        $this->log_repository->logActivity('Updated division with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.division')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->division_repository->delete($id);
        $this->log_repository->logActivity('Deleted division with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.division')->with('success', 'Data updated successfully!');
    }
}
