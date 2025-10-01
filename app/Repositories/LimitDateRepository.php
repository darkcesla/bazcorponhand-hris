<?php

namespace App\Repositories;

use App\Models\LimitDate;

class LimitDateRepository {

    public function getList()
    {
        $query = LimitDate::query();
        $data = $query->with('company')->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = LimitDate::with('company')->find($id);
        return $data;
    }

    public function create(array $data)
    {
        return LimitDate::create($data);
    }

    public function update(int $id, array $data)
    {
        return LimitDate::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = LimitDate::findOrFail($id);
        $data->delete();
        return true;
    }
}