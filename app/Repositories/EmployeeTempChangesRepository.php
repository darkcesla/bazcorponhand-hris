<?php

namespace App\Repositories;

use App\Models\EmployeeTempChanges;

class EmployeeTempChangesRepository {

    public function getList($params)
    {
        $query = EmployeeTempChanges::query();
        if (isset($params['approval_status'])) {
            $query->where('approval_status', $params['approval_status']);
        }
        $data = $query->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = EmployeeTempChanges::find($id);
        return $data;
    }

    public function create(array $data)
    {
        return EmployeeTempChanges::create($data);
    }

    public function update(int $id, array $data)
    {
        return EmployeeTempChanges::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = EmployeeTempChanges::findOrFail($id);
        $data->delete();
        return true;
    }
}