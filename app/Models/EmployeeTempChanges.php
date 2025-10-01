<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeTempChanges extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "employee_temp_changes";

    protected $fillable = [
        'date',
        'record_id',
        'original_data',
        'changed_data',
        'user_id',
        'approval_status',
        'approved_by',
    ];
}
