<?php

namespace App\Models\NewModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'slug',
        'content'
    ];
}
