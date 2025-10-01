<?php

namespace App\Repositories;

use App\Models\EmployeeShiftGroup;

class EmployeeShiftGroupRepository {

    public function getList()
    {
        $query = EmployeeShiftGroup::query();
        $data = $query->with('employee')->with('shift_group')->get();
        return $data;
    }

    public function getEmployeeList($id)
    {
        $query = EmployeeShiftGroup::query();
        $data = $query->with('employee')->with('shift_group')->where('shift_group_id',$id)->get();
        return $data;
    }

    public function getEmployeeGroup($id)
    {
        $query = EmployeeShiftGroup::query();
        $data = $query->with('employee')->with('shift_group')->where('employee_id',$id)->first();
        return $data;
    }
    
    public function show(int $id)
    {
        $data = EmployeeShiftGroup::with('employee')->with('shift_group')->find($id);
        return $data;
    }

    public function create(array $data)
    {
        return EmployeeShiftGroup::create($data);
    }

    public function update(int $id, array $data)
    {
        return EmployeeShiftGroup::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = EmployeeShiftGroup::findOrFail($id);
        $data->delete();
        return true;
    }
}