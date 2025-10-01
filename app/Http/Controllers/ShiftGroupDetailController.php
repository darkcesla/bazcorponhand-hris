<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\ShiftGroupDetailRepository;
use Illuminate\Http\Request;

class ShiftGroupDetailController extends Controller
{
    protected $shift_group_detail_repository;

    public function __construct(ShiftGroupDetailRepository $shift_group_detail_repository)
    {
        $this->shift_group_detail_repository = $shift_group_detail_repository;
    }

    public function index()
    {
        $shift_group_detail = $this->shift_group_detail_repository->getList(1);
        return view('shift_group_detail.index', ['shift_group_detail' => $shift_group_detail]);
    }
    public function store(Request $request)
    {
        $data = $request->only([]);
        $succesStatus = $this->shift_group_detail_repository->create($data);
        return redirect()->route('admin.shift_group_detail')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        return view('shift_group_detail.create');
    }

    public function edit($id)
    {
        $shift_group_detail = $this->shift_group_detail_repository->show($id);
        return view('shift_group_detail.edit', ['shift_group_detail' => $shift_group_detail]);
    }

    public function show($id)
    {
        $shift_group_detail = $this->shift_group_detail_repository->show($id);
        return view('shift_group_detail.show', ['shift_group_detail' => $shift_group_detail]);
    }

    public function update(Request $request, $id)
    {
        $request->only([]);
        $data = $request->only([]);
        $succesStatus = $this->shift_group_detail_repository->update($id, $data);
        return redirect()->route('admin.shift_group_detail')->with('success', 'Data updated successfully!');
    }

    public function destroy($id)
    {
        $succesStatus = $this->shift_group_detail_repository->delete($id);
        return redirect()->route('admin.shift_group_detail')->with('success', 'Data updated successfully!');
    }
}