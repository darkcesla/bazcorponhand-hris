<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveType extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "leave_type";
    protected $fillable = [
        'leave_code',
        'leave_name',
        'eligibility_leave',
        'limit_date',
        'limit_date_id',
        'deducted_leave',
        'day_count',
        'leave_day_type',
        'validate_attendance_status',
        'once_in_employment_period',
        'once_in_balance_period',
        'balance_period_limit',
        'leave_period_base_on',
    ];

    public function employeeLeaveBalances() : HasMany{
        return $this->hasMany(EmployeeLeaveBalance::class, 'leave_type_id', 'id');
    }
}
