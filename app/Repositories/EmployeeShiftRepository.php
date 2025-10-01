<?php

namespace App\Repositories;

use App\Models\EmployeeShift;

class EmployeeShiftRepository
{

    public function getList($params)
    {
        $currentDate = new \DateTime();
        $startDate = $currentDate->modify('monday this week')->format('Y-m-d');
        $endDate = $currentDate->modify('sunday this week')->format('Y-m-d');
        $query = EmployeeShift::query();
        $query->with('employee')->with('shift_daily')->get();
        if (isset($params['employee_id'])) {
            $query->where('employee_id', $params['employee_id'])
                ->orderBy('date', 'asc')
                ->whereBetween('date', [$startDate, $endDate]);
        }
        $data = $query->get();
        return $data;
    }

    public function getMonthList($params)
    {
        $currentDate = new \DateTime();
        $startDate = $currentDate->modify('first day of this month')->format('Y-m-d');
        $endDate = $currentDate->modify('last day of this month')->format('Y-m-d');
        $query = EmployeeShift::query();
        $query->with(['shift_daily:id,shift_daily_code,day_type,start_time,end_time,break_start,break_end'])
            ->select(
                'id',
                'date',
                'shift_daily_id',
            )
            ->where('employee_id', $params['employee_id'])
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->orderBy('date', 'desc');
        $data = $query->paginate($params['per_page']);
        return $data;
    }

    public function show(int $id)
    {
        $data = EmployeeShift::with('employee')->with('shift_daily')->find($id);
        return $data;
    }

    public function create(array $data)
    {
        return EmployeeShift::create($data);
    }

    public function update(int $id, array $data)
    {
        return EmployeeShift::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $data = EmployeeShift::findOrFail($id);
        $data->delete();
        return true;
    }
}
