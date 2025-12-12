<?php

namespace App\Models\NewModels;

use Illuminate\Database\Eloquent\Model;

class ImportantLink extends Model
{
    protected $fillable = ['title', 'url', 'image', 'status'];
    public $casts = ['status'=>'boolean'];
}
