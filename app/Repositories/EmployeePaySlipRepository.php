<?php

namespace App\Repositories;

use App\Models\EmployeePaySlip;

class EmployeePaySlipRepository {

    public function getList()
    {
        $query = EmployeePaySlip::query();
        $data = $query->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = EmployeePaySlip::find($id);
        return $data;
    }

    public function create(array $data)
    {
        return EmployeePaySlip::create($data);
    }

    public function update(int $id, array $data)
    {
        return EmployeePaySlip::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = EmployeePaySlip::findOrFail($id);
        $data->delete();
        return true;
    }
}