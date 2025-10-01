<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "shift_group";
    protected $fillable = [
        'group_code',
        'group_name',
        'overtime_based_on',
        'total_days',
    ];

    public function shiftDailys()
    {
        return $this->belongsToMany(ShiftDaily::class, 'shift_group_detail')->withPivot('day_order', 'shift_group_id', 'shift_daily_id');
    }
}
