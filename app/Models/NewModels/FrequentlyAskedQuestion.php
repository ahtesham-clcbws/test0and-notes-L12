<?php

namespace App\Models\NewModels;

use Illuminate\Database\Eloquent\Model;

class FrequentlyAskedQuestion extends Model
{
    protected $fillable = ['question', 'answer', 'status'];
    public $casts = ['status'=>'boolean'];
}
