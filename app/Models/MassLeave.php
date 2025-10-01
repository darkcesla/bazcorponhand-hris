<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MassLeave extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "mass_leave";
    protected $fillable = [
        'mass_leave_name',
        'employee_id',
        'leave_type_id',
        'start_date',
        'end_date',
    ];

    public function leave_type(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class);
    }

}
