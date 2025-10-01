<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeLeaveHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "employee_leave_history";
    protected $fillable = [
        'leave_type_id',
        'employee_id',
        'start_date',
        'end_date',
        'day_count',
        'superior_approval',
        'hr_approval',
        'approval_status',
        'notes',
    ];

    public function leave_type(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
