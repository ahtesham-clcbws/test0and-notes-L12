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
        'inactive_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function city_data()
    {
        return $this->belongsTo(City::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
