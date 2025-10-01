<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OvertimeSalary extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "overtime_salary";
    protected $fillable = [
        'company_id',
        'code',
        'salary_per_hour',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
