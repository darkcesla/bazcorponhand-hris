<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "attendance";

    protected $fillable = [
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
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function shift_daily(): BelongsTo
    {
        return $this->belongsTo(ShiftDaily::class);
    }

    public function attendance_location(): BelongsTo
    {
        return $this->belongsTo(AttendanceLocation::class);
    }
}
