<?php

namespace App\Repositories;

use App\Models\Overtime;

class OvertimeRepository
{

    public function getList($params)
    {
        try {
            $query = Overtime::query();

            if (isset($params['start_date'])) {
                $query->where('date', '>=', $params['start_date']);
            }

            if (isset($params['end_date'])) {
                $query->where('date', '<=', $params['end_date']);
            }

            if (isset($params['company_id'])) {
                $query->whereHas('employee', function ($query) use ($params) {
                    $query->where('company_id', $params['company_id']);
                });
            }

            if (isset($params['employee_id'])) {
                $query->where('employee_id', $params['employee_id'])
                    ->orderBy('date', 'desc');
            } else {
                $query->orderBy('employee_id', 'asc')
                    ->orderBy('date', 'asc');
            }

            $query->with(['employee:id,firstname,lastname,employee_no,company_id'])
                ->select(
                    'id',
                    'date',
                    'employee_id',
                    'day_type',
                    'start_time',
                    'end_time',
                    'description',
                    'total_hour',
                    'salary_per_hour',
                    'total_salary'
                );

            if (isset($params['page']) && isset($params['per_page'])) {
                $data = $query->paginate($params['per_page']);
            } else {
                $data = $query->get();
            }
            if ($data === null) {
                throw new \Exception("Error: Overtime::getList() returned null.");
            }
            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function show(int $id)
    {
        try {
            $data = Overtime::with("employee")->find($id);
            if ($data === null) {
                throw new \DomainException("Overtime with id $id not found.");
            }
            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function create(array $data)
    {
        try {
            return Overtime::create($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update(int $id, array $data)
    {
        try {
            return Overtime::where('id', $id)->update($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function delete($id)
    {
        try {
            $data = Overtime::findOrFail($id);
            $data->delete();
            return true;
        } catch (\Exception $e) {
            if ($e instanceof \TypeError) {
                throw $e;
            }

            throw new \DomainException('Error occurred while deleting Overtime entity. Please check your input and try again.');
        }
    }
}
