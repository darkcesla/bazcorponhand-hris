<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Position extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $table = "position";
    protected $fillable = [
        'division_id',
        'name',
    ];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
}
