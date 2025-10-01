<?php

namespace App\Repositories;

use App\Models\ShiftGroupDetail;

class ShiftGroupDetailRepository
{

    public function getList($shift_group_id)
    {
        $query = ShiftGroupDetail::query();
        $data = $query->where('shift_group_id', $shift_group_id)->with('shiftDaily')->get();
        return $data;
    }


    public function show(int $id)
    {
        $data = ShiftGroupDetail::find($id);
        return $data;
    }

    public function create(array $datas)
    {
        foreach ($datas as $data) {
            ShiftGroupDetail::create($data);
        }
        return true;
    }

    public function update(int $id, array $data)
    {
        return ShiftGroupDetail::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $data = ShiftGroupDetail::findOrFail($id);
        $data->delete();
        return true;
    }

    public function batchDelete($shift_group_id)
    {
        ShiftGroupDetail::where('shift_group_id', $shift_group_id)->delete();
        return true;
    }
}
