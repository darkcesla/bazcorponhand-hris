<?php

namespace App\Repositories;

use App\Models\EmployeeMassLeave;

class EmployeeMassLeaveRepository
{

    public function getList($mass_leave_id)
    {
        $query = EmployeeMassLeave::query();
        $data = $query->where('mass_leave_id', '=', $mass_leave_id)->with('employee')->get();
        return $data;
    }


    public function show(int $id)
    {
        $data = EmployeeMassLeave::find($id);
        return $data;
    }

    public function create(array $data)
    {
        return EmployeeMassLeave::create($data);
    }

    public function update(int $id, array $data)
    {
        return EmployeeMassLeave::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $data = EmployeeMassLeave::findOrFail($id);
        $data->delete();
        return true;
    }
}
