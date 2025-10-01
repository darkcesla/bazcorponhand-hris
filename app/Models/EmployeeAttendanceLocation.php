<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeAttendanceLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "employee_attendance_location";
    protected $fillable = [
        'attendance_location_id',
        'employee_id',
        'start_date',
        'end_date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function attendance_location(): BelongsTo
    {
        return $this->belongsTo(AttendanceLocation::class);
    }
}
