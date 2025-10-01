<?php

namespace App\Repositories;

use App\Models\OvertimeSalary;

class OvertimeSalaryRepository {

    public function getList()
    {
        $query = OvertimeSalary::query();
        $data = $query->with("company")->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = OvertimeSalary::with("company")->find($id);
        return $data;
    }

    public function create(array $data)
    {
        return OvertimeSalary::create($data);
    }

    public function update(int $id, array $data)
    {
        return OvertimeSalary::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = OvertimeSalary::findOrFail($id);
        $data->delete();
        return true;
    }
}