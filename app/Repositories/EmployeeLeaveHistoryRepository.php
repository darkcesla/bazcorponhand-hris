<?php

namespace App\Repositories;

use App\Models\EmployeeLeaveHistory;

class EmployeeLeaveHistoryRepository
{

    public function getList($params)
    {
        try {
            $query = EmployeeLeaveHistory::query();
            $query->with(['employee:id,firstname,lastname,employee_no,company_id', 'leave_type'])
                ->select(
                    'id',
                    'leave_type_id',
                    'employee_id',
                    'start_date',
                    'end_date',
                    'day_count',
                    'superior_approval',
                    'hr_approval',
                    'approval_status',
                    'notes',
                    'created_at'
                );

            if (isset($params['company_id'])) {
                $query->where(function ($q) use ($params) {
                    $q->where('company_id', $params['company_id'])
                        ->orWhereNull('company_id');
                });
            }
            if (isset($params['employee_id'])) {
                $query->where('employee_id', $params['employee_id'])
                    ->orderBy('start_date', 'desc');
            } else {
                $query->orderBy('employee_id', 'asc')
                    ->orderBy('start_date', 'asc');
            }

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
        $data = EmployeeLeaveHistory::find($id);
        return $data;
    }

    public function create(array $data)
    {
        return EmployeeLeaveHistory::create($data);
    }

    public function update(int $id, array $data)
    {
        return EmployeeLeaveHistory::where('id', $id)->update($data);
    }

    public function approve(int $id)
    {
        $data = [
            'superior_approval' => true,
            'approval_status' => 'approve'
        ];

        return EmployeeLeaveHistory::where('id', $id)->update($data);
    }

    public function reject(int $id)
    {
        $data = [
            'superior_approval' => false,
            'approval_status' => 'reject'
        ];
        return EmployeeLeaveHistory::where('id', $id)->update($data);
    }


    public function delete($id)
    {
        $data = EmployeeLeaveHistory::findOrFail($id);
        $data->delete();
        return true;
    }
}
