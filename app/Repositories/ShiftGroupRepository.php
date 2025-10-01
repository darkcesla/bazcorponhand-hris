<?php

namespace App\Repositories;

use App\Models\ShiftGroup;

class ShiftGroupRepository {

    public function getList()
    {
        $query = ShiftGroup::query();
        $data = $query->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = ShiftGroup::find($id);
        return $data;
    }

    public function create(array $data)
    {
        return ShiftGroup::create($data);
    }

    public function update(int $id, array $data)
    {
        return ShiftGroup::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = ShiftGroup::findOrFail($id);
        $data->delete();
        return true;
    }
}