<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Allowance extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'payroll_id',
        'allowance_type_id',
        'amount'
    ];

    public function payroll(): BelongsTo
    {
        return $this->belongsTo(EmployeePayroll::class);
    }

    public function allowanceType(): BelongsTo
    {
        return $this->belongsTo(AllowanceType::class);
    }
}
