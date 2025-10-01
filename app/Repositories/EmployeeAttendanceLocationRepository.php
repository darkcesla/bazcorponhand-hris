<?php

namespace App\Repositories;

use App\Models\EmployeeAttendanceLocation;

class EmployeeAttendanceLocationRepository {

    public function getList()
    {
        $query = EmployeeAttendanceLocation::query();
        $data = $query->with('employee')->with('attendance_location')->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = EmployeeAttendanceLocation::find($id);
        return $data;
    }

    public function create(array $data)
    {
        return EmployeeAttendanceLocation::create($data);
    }

    public function update(int $id, array $data)
    {
        return EmployeeAttendanceLocation::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = EmployeeAttendanceLocation::findOrFail($id);
        $data->delete();
        return true;
    }
}