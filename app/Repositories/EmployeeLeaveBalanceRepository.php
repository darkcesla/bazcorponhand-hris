<?php

namespace App\Repositories;

use App\Models\EmployeeLeaveBalance;

class EmployeeLeaveBalanceRepository {

    public function getList()
    {
        $query = EmployeeLeaveBalance::query();
        $data = $query->with('employee')->with('leave_type')->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = EmployeeLeaveBalance::find($id);
        return $data;
    }

    public function create(array $data)
    {
        return EmployeeLeaveBalance::create($data);
    }

    public function update(int $id, array $data)
    {
        return EmployeeLeaveBalance::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = EmployeeLeaveBalance::findOrFail($id);
        $data->delete();
        return true;
    }
}