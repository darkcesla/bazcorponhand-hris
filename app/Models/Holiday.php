<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "holiday";
    protected $fillable = [
        'holiday_name',
        'start_date',
        'end_date',
        'holiday_type',
        'religion',
        'nationality',
        'recur_every_year',
    ];
}
