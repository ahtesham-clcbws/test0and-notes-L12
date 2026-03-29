<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'photo_url',
        'series_id',
        'about',
        'institute_code',
        'city',
        'state',
        'country',
        'is_franchise',
        'is_staff',
        'allowed_to_upload',
        'days',
        'started_at',
        'inactive_at',
        'education_type',
        'class',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city_data()
    {
        return $this->belongsTo(City::class, 'city');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state');
    }

    public function education_type_data()
    {
        return $this->belongsTo(Educationtype::class, 'education_type');
    }

    public function class_data()
    {
        return $this->belongsTo(ClassGoupExamModel::class, 'class');
    }
}
