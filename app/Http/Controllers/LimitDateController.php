<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\LimitDateRepository;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class LimitDateController extends Controller
{
    protected $limit_date_repository;
    protected $company_repository;
    protected $log_repository;

    public function __construct(
        LimitDateRepository $limit_date_repository,
        CompanyRepository $company_repository,
        LogRepository $log_repository
    ) {
        $this->limit_date_repository = $limit_date_repository;
        $this->company_repository = $company_repository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        $limit_date = $this->limit_date_repository->getList();
        return view('limit_date.index', ['limit_date' => $limit_date]);
    }
    public function store(Request $request)
    {
        $data = $request->only([
            'company_id',
            'date',
        ]);
        $succesStatus = $this->limit_date_repository->create($data);
        $this->log_repository->logActivity('Created limit date', $request->ip());
        return redirect()->route('admin.limit_date')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        $company = $this->company_repository->getList();
        return view('limit_date.create', ['company' => $company]);
    }

    public function edit($id)
    {
        $company = $this->company_repository->getList();
        $limit_date = $this->limit_date_repository->show($id);
        return view('limit_date.edit', ['limit_date' => $limit_date, 'company' => $company]);
    }

    public function show($id)
    {
        $limit_date = $this->limit_date_repository->show($id);
        return view('limit_date.show', ['limit_date' => $limit_date]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'company_id',
            'date',
        ]);
        $succesStatus = $this->limit_date_repository->update($id, $data);
        $this->log_repository->logActivity('Updated limit date with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.limit_date')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->limit_date_repository->delete($id);
        $this->log_repository->logActivity('Deleted limit date with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.limit_date')->with('success', 'Data updated successfully!');
    }
}
