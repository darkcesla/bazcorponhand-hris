<?php

namespace App\Repositories;

use App\Models\AttendanceLocation;

class AttendanceLocationRepository {

    public function getList()
    {
        $query = AttendanceLocation::query();
        $data = $query->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = AttendanceLocation::find($id);
        return $data;
    }

    public function create(array $data)
    {
        return AttendanceLocation::create($data);
    }

    public function update(int $id, array $data)
    {
        return AttendanceLocation::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = AttendanceLocation::findOrFail($id);
        $data->delete();
        return true;
    }
}