<?php

namespace App\Repositories;

use App\Models\Attendance;
use Illuminate\Support\Carbon;

class AttendanceRepository
{

    public function getList($params)
    {
        try {
            $query = Attendance::query();

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
            if (isset($params['employee_ids'])) {
                $query->whereIn('employee_id', $params['employee_ids']);
            }
            if (isset($params['off_status'])) {
                $query->whereHas('shift_daily', function ($query) use ($params) {
                    $query->where('shift_daily_code', '!=', 'OFF');
                });
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

            $query->with(['employee:id,firstname,lastname,employee_no,company_id', 'shift_daily', 'attendance_location'])
                ->select(
                    'id',
                    'date',
                    'employee_id',
                    'shift_daily_id',
                    'attendance_location_id',
                    'check_in',
                    'check_out',
                    'check_in_longitude',
                    'check_in_latitude',
                    'check_out_longitude',
                    'check_out_latitude',
                    'check_in_image',
                    'check_out_image',
                    'status'
                );

            if (isset($params['page']) && isset($params['per_page'])) {
                $data = $query->paginate($params['per_page']);
            } else {
                $data = $query->get();
            }
            $data->each(function ($attendance) {
                if (!empty($attendance->shift_daily->start_time) && !empty($attendance->check_in)) {
                    try {
                        $checkIn = Carbon::createFromFormat('H:i:s', $attendance->check_in);
                        $startTime = Carbon::createFromFormat('H:i:s', $attendance->shift_daily->start_time);
                        $attendance->in_diff = $startTime->diffInMinutes($checkIn, false);
                    } catch (\Exception $e) {
                        $attendance->in_diff = null;
                    }
                } else {
                    $attendance->in_diff = null;
                }
                if (!empty($attendance->shift_daily->start_time) && !empty($attendance->check_in)) {
                    try {
                        $checkOut = Carbon::createFromFormat('H:i:s', $attendance->check_out);
                        $endTime = Carbon::createFromFormat('H:i:s', $attendance->shift_daily->end_time);
                        $attendance->out_diff = $endTime->diffInMinutes($checkOut, false);
                    } catch (\Exception $e) {
                        $attendance->out_diff = null;
                    }
                } else {
                    $attendance->out_diff = null;
                }
            });
            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function apiList($data)
    {
        try {
            $query = Attendance::query();

            if (isset($data['start_date']) && isset($data['end_date'])) {
                $startDate = $data['start_date'];
                $endDate = $data['end_date'];

                $query->whereBetween('date', [$startDate, $endDate]);
            }

            $overtime = $query->paginate($data['per_page']);

            return [
                'data' => $overtime,
                'error' => null
            ];
        } catch (\Exception $e) {
            return [
                'data' => null,
                'error' => $e->getMessage()
            ];
        }
    }

    public function getListUser($id)
    {
        $query = Attendance::query();
        $data = $query->with('employee', 'shift_daily', 'attendance_location')->where('employee_id', $id)->get();
        return $data;
    }

    function getAttendanceIssue($params)
    {
        $company_id = isset($params['company_id']) ? $params['company_id'] : 0;
        $currentYear = Carbon::now()->year;
        $months = [];

        for ($month = 1; $month <= 12; $month++) {
            $months[] = Carbon::createFromDate($currentYear, $month, 1)->format('F');
        }

        $attendanceData = Attendance::select(
            Attendance::raw("DATE_FORMAT(date, '%M') as month"),
            'status',
            Attendance::raw('COUNT(*) as attendance_count')
        )
            ->where('status', '!=', 1)
            ->whereYear('date', $currentYear);

        if ($company_id != 0) {
            $attendanceData->whereHas('employee', function ($query) use ($company_id) {
                $query->where('company_id', '=', $company_id);
            });
        }

        $attendanceData = $attendanceData->groupBy('month', 'status')
            ->get();

        $attendanceIssues = collect($months)->map(function ($month) use ($attendanceData) {
            $monthAttendanceData = $attendanceData->filter(function ($attendance) use ($month) {
                return $attendance->month == $month;
            })->groupBy('status')
                ->map->sum('attendance_count')
                ->toArray();

            return [
                'month' => $month,
                'status' => [
                    0 => $monthAttendanceData[0] ?? 0,
                    2 => $monthAttendanceData[2] ?? 0,
                ]
            ];
        });

        return $attendanceIssues;
    }

    public function show(int $id)
    {
        $data = Attendance::with('employee', 'shift_daily', 'attendance_location')->find($id);
        return $data;
    }

    public function create(array $data)
    {
        return Attendance::create($data);
    }

    public function update(int $id, array $data)
    {
        return Attendance::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $data = Attendance::findOrFail($id);
        $data->delete();
        return true;
    }

    public function current($employee_id)
    {
        $currentDate = Carbon::today();
        $data = Attendance::with('employee', 'shift_daily', 'attendance_location')
            ->where('date', $currentDate)
            ->where('employee_id', $employee_id)
            ->first();
        return $data;
    }
}
