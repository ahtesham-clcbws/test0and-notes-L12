<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignClassSubjectsModel extends Model
{
    use HasFactory;

    protected $table = 'assign_classes_subjects';
    protected $primaryKey = 'id';

    protected $fillable = [
        'class_id',
        'subject_id'
    ];
}
