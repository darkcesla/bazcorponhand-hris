<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\EmployeeShift;
use App\Models\Employee;
use App\Models\ShiftDaily;
use App\Models\Attendance;
use Carbon\Carbon;

class EmployeShiftImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $rownum = 1;
        $columns = [];
        $count = 0;
        foreach ($collection as $row) {
            if ($rownum == 1) {
                $columns = $row;
                $count = count($columns);
                $rownum += 1;
            } else {
                $employee_no = $row[1];
                $employee  = Employee::where('employee_no', $employee_no)->first();
                $employee_id = $employee->id;
                for ($i = 2; $i < $count; $i++) {
                    $baseDate = Carbon::createFromDate(1899, 12, 30);
                    $date = $baseDate->addDays($columns[$i])->toDateString();
                    $shift_daily = ShiftDaily::where('shift_daily_code', $row[$i])->first();
                    $shift_daily_id = $shift_daily->id;
                    $data['employee_id'] = $employee_id;
                    $data['date'] = $date;
                    $data['shift_daily_id'] = $shift_daily_id;
                    $data['status'] = 0;

                    EmployeeShift::updateOrCreate(
                        ['employee_id' => $employee_id, 'date' => $date, 'shift_daily_id' => $shift_daily_id],
                        $data
                    );
                    if ($row[$i] != 'OFF') {
                        Attendance::updateOrCreate(['employee_id' => $employee_id, 'date' => $date, 'shift_daily_id' => $shift_daily_id], $data);
                    }
                }
            }
        }
    }
}
