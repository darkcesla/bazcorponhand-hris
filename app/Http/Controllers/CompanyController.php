<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class CompanyController extends Controller
{
    protected $company_repository;
    protected $log_repository;

    public function __construct(
        CompanyRepository $company_repository,
        LogRepository $log_repository
    ) {
        $this->company_repository = $company_repository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        $company = $this->company_repository->getList();
        return view('company.index', ['company' => $company]);
    }
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'country',
            'site',
        ]);
        $this->company_repository->create($data);
        $this->log_repository->logActivity('Create company', $request->ip());
        return redirect()->route('admin.company');
    }

    public function create()
    {
        return view('company.create');
    }

    public function edit($id)
    {
        $company = $this->company_repository->show($id);
        return view('company.edit', ['company' => $company]);
    }

    public function show($id)
    {
        $company = $this->company_repository->show($id);
        return view('company.show', ['company' => $company]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'name',
            'country',
            'site',
        ]);
        $succesStatus = $this->company_repository->update($id, $data);
        $this->log_repository->logActivity('Updated company with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.company')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->company_repository->delete($id);
        $this->log_repository->logActivity('Deleted company with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.company')->with('success', 'Data updated successfully!');
    }

    public function select(Request $request)
    {
        $selectedCompany = $request->input('selected_company');
        session(['selected_company' => $selectedCompany]);
        return redirect()->back();
    }
}
