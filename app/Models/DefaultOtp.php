<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultOtp extends Model
{
    protected $fillable = [
        'otp',
        'is_active',
        'description',
    ];
}
