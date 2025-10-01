<?php

namespace App\Repositories;

use App\Models\EmployeePayroll;

class EmployeePayrollRepository
{

    public function getList()
    {
        try {
            $query = EmployeePayroll::query();
            if (isset($params['start_date']) && isset($params['end_date'])) {
                $startDate = $params['start_date'];
                $endDate = $params['end_date'];

                $query->whereBetween('date', [$startDate, $endDate]);
            }

            if (isset($params['company_id'])) {
                $query->whereHas('employee', function ($query) use ($params) {
                    $query->where('company_id', $params['company_id']);
                });
            }

            $query->with(['employee:id,firstname,lastname,employee_no,company_id'])
                ->select(
                    'id',
                    'employee_id',
                    'effective_salary_date',
                    'title',
                    'tax_flag',
                    'salary_received',
                    'basic_salary',
                    'allowance',
                    'total_allowance',
                    'bpjs_ketenagakerjaan',
                    'bpjs_kesehatan',
                    'insurance',
                    'insurance_number',
                    'tax_number',
                    'tax_type',
                );

            $data = $query->with('employee')->get();
        } catch (\Throwable $e) {
            throw $e;
        }
        return $data;
    }

    public function getPreview($params)
    {
        $query = EmployeePayroll::query();
        $data = $query->with('employee')->get();
        return $data;
    }

    public function getEmployeePayroll($id)
    {
        $query = EmployeePayroll::query();
        $data = $query->with('employee')->where('employee_id', $id)->first();
        return $data;
    }

    public function show(int $id)
    {
        $data = EmployeePayroll::with('employee')->find($id);
        return $data;
    }

    public function create(array $data)
    {
        return EmployeePayroll::create($data);
    }

    public function update(int $id, array $data)
    {
        return EmployeePayroll::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $data = EmployeePayroll::findOrFail($id);
        $data->delete();
        return true;
    }
}
