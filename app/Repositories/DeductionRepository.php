<?php

namespace App\Repositories;

use App\Models\Deduction;

class DeductionRepository
{

    public function getList($params)
    {
        $query = Deduction::query();

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
        $data = Deduction::with('employee')->find($id);
        return $data;
    }

    public function create(array $data)
    {
        return Deduction::create($data);
    }

    public function update(int $id, array $data)
    {
        return Deduction::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $data = Deduction::findOrFail($id);
        $data->delete();
        return true;
    }
}
