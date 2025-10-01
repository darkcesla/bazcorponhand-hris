<?php

namespace App\Repositories;

use App\Models\Division;

class DivisionRepository {

    public function getList($params)
    {
        $query = Division::query();
        if (isset($params['company_id'])) {
            $query->where(function ($q) use ($params) {
                $q->where('company_id', $params['company_id']);
            });
        }
        $data = $query->with('company')->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = Division::with('company')->find($id);
        return $data;
    }

    public function create(array $data)
    {
        return Division::create($data);
    }

    public function update(int $id, array $data)
    {
        return Division::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = Division::findOrFail($id);
        $data->delete();
        return true;
    }
}