<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "company";
    protected $fillable = [
        'name',
        'country',
        'site',
    ];
    
    public function divisions() : HasMany
    {
        return $this->hasMany(Division::class);
    }
}
