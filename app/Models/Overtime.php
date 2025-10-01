<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Overtime extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "overtime";
    protected $fillable = [
        'employee_id',
        'date',
        'day_type',
        'start_time',
        'end_time',
        'total_hour',
        'overtime_salary_id',
        'description',
        'total_salary',
        'salary_per_hour',
        'attachment'
    ];

    public function salary(): BelongsTo
    {
        return $this->belongsTo(OvertimeSalary::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
