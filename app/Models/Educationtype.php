<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Educationtype extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'education_type';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name'
    ];

    public function class_exam()
    {
        return $this->belongsToMany(ClassGoupExamModel::class, 'gn__assign_class_group_exam_names', 'education_type_id', 'classes_group_exams_id');
    }
}
