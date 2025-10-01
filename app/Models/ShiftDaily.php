<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftDaily extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "shift_daily";
    protected $fillable = [
        'shift_daily_code',
        'day_type',
        'start_time',
        'end_time',
        'grace_for_late',
        'productive_work_time',
        'break_start',
        'break_end',
        'remark',
    ];

    public function shiftGroups()
    {
        return $this->belongsToMany(ShiftGroup::class, 'shift_group_detail')->withPivot('day_order', 'shift_group_id', 'shift_daily_id');
    }
}
