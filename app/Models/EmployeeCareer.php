<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeCareer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "employee_career";
    protected $fillable = [
        'transition_number',
        'employee_id',
        'letter',
        'transition_type',
        'join_date',
        'employment_type',
        'termination_type',
        'date',
        'start_date',
        'end_date',
        'position',
        'department'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
