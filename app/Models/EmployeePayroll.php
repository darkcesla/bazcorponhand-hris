<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeePayroll extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "employee_payroll";
    protected $fillable = [
        'employee_id',
        'effective_salary_date',
        'title',
        'tax_flag',
        'salary_received',
        'basic_salary',
        'allowance',
        'total_allowance',
        'bpjs_ketenagakerjaan',
        'bpjs_kesehatan',
        'insurance',
        'insurance_number',
        'tax_number',
        'tax_type',
        'pay_frequency'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
