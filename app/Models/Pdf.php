<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    
    use HasFactory;
    protected $table = 'pdfs';
    protected $primaryKey = 'id';
    protected $fillable = ['title','type','file'];    
}
