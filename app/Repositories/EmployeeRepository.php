<?php

namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeRepository
{

    public function getList()
    {
        $query = Employee::query();
        $data = $query->get();
        return $data;
    }

    public function getListParams()
    {
        $query = Employee::query();
        $data = $query->select([
            'id',
            DB::raw("CONCAT(firstname, ' ', lastname) AS name"),
            'employee_no'
        ])->get();
        return $data;
    }

    public function getListCompany($company_id)
    {
        $query = Employee::query();
        $query->with('position');
        $data = $query->where('company_id', $company_id)->get();
        return $data;
    }

    public function getListUser($params)
    {
        $query = Employee::query();
        $query->whereNotNull('user_id');
        if (isset($params['company_id'])) {
            $query->where('company_id', $params['company_id']);      
        }
        $data = $query->pluck('user_id');
        return $data;
    }


    public function getGenderRatio($params)
    {
        $query = Employee::query();
        $query->select('gender', Employee::raw('COUNT(*) as count'))->groupBy('gender');
        if (isset($params['company_id'])) {
            $query->where(function ($q) use ($params) {
                $q->where('company_id', $params['company_id'])
                    ->orWhereNull('company_id');
            });
        }
        $genderCounts = $query->get();
        return $genderCounts;
    }


    public function show(int $id)
    {
        $data = Employee::find($id);
        return $data;
    }

    public function getByUserId(int $user_id)
    {
        try {
            $employee = Employee::where('user_id', $user_id)->first();
            if (is_null($employee)) {
                return null;
            }
            return $employee;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function create(array $data)
    {
        return Employee::create($data);
    }

    public function update(int $id, array $data)
    {
        return Employee::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $data = Employee::findOrFail($id);
        $data->delete();
        return true;
    }

    public function kpi()
    {
        $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
        $employees = Employee::select('firstname', 'lastname')
            ->selectRaw('COUNT(a.employee_id) as attendance')
            ->selectRaw('COUNT(CASE WHEN a.status = 1 THEN 1 END) as present')
            ->leftJoin('attendance as a', 'employee.id', '=', 'a.employee_id')
            ->where('a.date', '>=', $startOfMonth)
            ->where('a.date', '<=', \Carbon\Carbon::now())
            ->groupBy('firstname', 'lastname', 'employee.id')
            ->get();
        return $employees;
    }
}
