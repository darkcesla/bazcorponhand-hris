<?php

namespace App\Repositories;

use App\Models\MassLeave;

class MassLeaveRepository {

    public function getList()
    {
        $query = MassLeave::query();
        $data = $query->with('leave_type')->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = MassLeave::find($id);
        return $data;
    }

    public function create(array $data)
    {
        return MassLeave::create($data);
    }

    public function update(int $id, array $data)
    {
        return MassLeave::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = MassLeave::findOrFail($id);
        $data->delete();
        return true;
    }
}