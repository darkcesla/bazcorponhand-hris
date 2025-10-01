<?php

namespace App\Repositories;

use App\Models\Earning;

class EarningRepository
{

    public function getList($params)
    {
        $query = Earning::query();

        if (isset($params['year'])) {
            $query->whereYear('date', $params['year']);
        }

        if (isset($params['month'])) {
            $query->whereMonth('date', $params['month']);
        }

        if (isset($params['company_id'])) {
            $query->whereHas('employee', function ($query) use ($params) {
                $query->where('company_id', $params['company_id']);
            });
        }

        if (isset($params['employee_id'])) {
            $query->where('employee_id', $params['employee_id']);
        }
        $data = $query->with('employee')->get();
        return $data;
    }


    public function show(int $id)
    {
        $data = Earning::with('employee')->find($id);
        return $data;
    }

    public function create(array $data)
    {
        return Earning::create($data);
    }

    public function update(int $id, array $data)
    {
        return Earning::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $data = Earning::findOrFail($id);
        $data->delete();
        return true;
    }
}
