<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'user_type',
        'review_text',
        'is_approved',
        'is_featured',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
