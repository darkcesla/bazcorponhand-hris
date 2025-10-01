<?php

namespace App\Repositories;

use App\Models\AllowanceType;

class AllowanceTypeRepository
{

    public function getList()
    {
        $query = AllowanceType::query();
        $data = $query->get();
        return $data;
    }


    public function show(int $id)
    {
        $data = AllowanceType::find($id);
        return $data;
    }

    public function create(array $data)
    {
        return AllowanceType::create($data);
    }

    public function update(int $id, array $data)
    {
        return AllowanceType::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $data = AllowanceType::findOrFail($id);
        $data->delete();
        return true;
    }
}
