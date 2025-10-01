<?php

namespace App\Repositories;

use App\Models\Holiday;

class HolidayRepository {

    public function getList()
    {
        $query = Holiday::query();
        $data = $query->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = Holiday::find($id);
        return $data;
    }

    public function create(array $data)
    {
        return Holiday::create($data);
    }

    public function update(int $id, array $data)
    {
        return Holiday::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = Holiday::findOrFail($id);
        $data->delete();
        return true;
    }
}