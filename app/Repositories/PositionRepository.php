<?php

namespace App\Repositories;

use App\Models\Position;

class PositionRepository
{

    public function getList($params)
    {
        $query = Position::query();
        if (isset($params['company_id'])) {
            $query->whereHas('division', function ($query) use ($params) {
                $query->where('company_id', $params['company_id']);
            });
        }
        $data = $query->with('division:id,name')->get();
        return $data;
    }


    public function show(int $id)
    {
        $data = Position::with('division:id,name')->find($id);
        return $data;
    }

    public function create(array $data)
    {
        return Position::create($data);
    }

    public function update(int $id, array $data)
    {
        return Position::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $data = Position::findOrFail($id);
        $data->delete();
        return true;
    }
}
