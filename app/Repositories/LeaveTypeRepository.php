<?php

namespace App\Repositories;

use App\Models\LeaveType;

class LeaveTypeRepository {

    public function getList()
    {
        $query = LeaveType::query();
        $data = $query->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = LeaveType::find($id);
        return $data;
    }

    public function create(array $data)
    {
        return LeaveType::create($data);
    }

    public function update(int $id, array $data)
    {
        return LeaveType::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = LeaveType::findOrFail($id);
        $data->delete();
        return true;
    }
}