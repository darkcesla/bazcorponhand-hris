<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DivisionRepository;
use App\Repositories\LogRepository;
use App\Repositories\PositionRepository;

class PositionController extends Controller
{
    protected $position_repository;
    protected $division_repository;
    protected $log_repository;

    public function __construct(
        PositionRepository $position_repository,
        DivisionRepository $division_repository,
        LogRepository $log_repository
    ) {
        $this->position_repository = $position_repository;
        $this->division_repository = $division_repository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        try {
            $params = [];
            if (session('selected_company')) {
                $params['company_id'] = session('selected_company');
            }
            $positions = $this->position_repository->getList($params) ?: [];
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        return view('position.index', ['positions' => $positions]);
    }
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'division_id',
        ]);
        $succesStatus = $this->position_repository->create($data);
        $this->log_repository->logActivity('Created position', $request->ip());
        return redirect()->route('admin.position')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        $params = [];
        if (session('selected_company')) {
            $params['company_id'] = session('selected_company');
        }
        $divisions = $this->division_repository->getList($params);
        return view('position.create', ['divisions' => $divisions]);
    }

    public function edit($id)
    {
        $params = [];
        if (session('selected_company')) {
            $params['company_id'] = session('selected_company');
        }
        $divisions = $this->division_repository->getList($params);
        $position = $this->position_repository->show($id);
        return view('position.edit', ['position' => $position, 'divisions' => $divisions]);
    }

    public function show($id)
    {
        $position = $this->position_repository->show($id);
        return view('position.show', ['position' => $position]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'name',
            'division_id',
        ]);
        $succesStatus = $this->position_repository->update($id, $data);
        $this->log_repository->logActivity('Updated position with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.position')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->position_repository->delete($id);
        $this->log_repository->logActivity('Deleted position with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.position')->with('success', 'Data updated successfully!');
    }
}
