<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = ['id'];
    protected $table = "employee";
    protected $fillable = [
        'company_id',
        'user_id',
        'employee_no',
        'access_card_id',
        'firstname',
        'lastname',
        'nickname',
        'id_card',
        'birth_place',
        'birth_date',
        'gender',
        'marital_status',
        'religion',
        'height',
        'weight',
        'blood_type',
        'id_card_address',
        'address',
        'kta',
        'phone_number',
        'email',
        'social_media',
        'clothes_size',
        'trouser_size',
        'shoes_size',
        'language',
        'educational_level',
        'major',
        'skill',
        'emergency_contact_name',
        'emergency_contact_number',
        'position_id',
        'agreement_type',
        'join_date',
        'image',
        'cecrtificate', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
