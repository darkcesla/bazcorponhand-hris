<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftGroupDetail extends Pivot
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "shift_group_detail";
    protected $fillable = [
        'day_order',
        'shift_group_id',
        'shift_daily_id',
    ];

    public function shiftDaily()
    {
        return $this->belongsTo(ShiftDaily::class);
    }

    public function shiftGroup()
    {
        return $this->belongsTo(ShiftGroup::class);
    }
}
