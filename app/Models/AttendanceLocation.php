<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceLocation extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = ['id'];
    protected $table = "attendance_location";
    protected $fillable = [
        'location_code',
        'location_name',
        'location_address',
        'city',
        'province',
        'country',
        'max_radius',
        'longitude',
        'latitude',
    ];

}
