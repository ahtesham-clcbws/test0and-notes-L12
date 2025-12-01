<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefautlOtpNumber extends Model
{
    use HasFactory;
    protected $table = 'default_otp_number';
    protected $primaryKey = 'id';

    protected $fillable = [
        'mobile'
    ];
}
