<?php

namespace App\Repositories;

use App\Models\ShiftDaily;

class ShiftDailyRepository {

    public function getList()
    {
        $query = ShiftDaily::query();
        $data = $query->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = ShiftDaily::find($id);
        return $data;
    }

    public function create(array $data)
    {
        return ShiftDaily::create($data);
    }

    public function update(int $id, array $data)
    {
        return ShiftDaily::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = ShiftDaily::findOrFail($id);
        $data->delete();
        return true;
    }
}