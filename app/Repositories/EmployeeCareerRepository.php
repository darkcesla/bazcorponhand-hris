<?php

namespace App\Repositories;

use App\Models\EmployeeCareer;

class EmployeeCareerRepository {

    public function getList($params)
    {
        $query = EmployeeCareer::query();
        if (isset($params['last_contract']) && $params['last_contract']) {
            $threeMonthsFromNow = now()->addMonths(3)->endOfDay();
            $query->where('end_date', '<=', $threeMonthsFromNow);
            $query->orderBy('end_date', 'asc');
        }
        $data = $query->with('employee')->get();
        return $data;
    }
    
    
    public function show(int $id)
    {
        $data = EmployeeCareer::with('employee')->find($id);
        return $data;
    }

    public function create(array $data)
    {
        return EmployeeCareer::create($data);
    }

    public function update(int $id, array $data)
    {
        return EmployeeCareer::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = EmployeeCareer::findOrFail($id);
        $data->delete();
        return true;
    }
}