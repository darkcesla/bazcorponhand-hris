<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeShiftGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "employee_shift_group";
    protected $fillable = [
        'shift_group_id',
        'start_shift_date',
        'start_shift_daily',
        'always_present',
        'employee_id',
        'end_date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function shift_group(): BelongsTo
    {
        return $this->belongsTo(ShiftGroup::class);
    }
}
