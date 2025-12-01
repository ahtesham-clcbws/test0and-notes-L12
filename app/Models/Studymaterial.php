<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studymaterial extends Model
{
    use HasFactory;
    protected $table = 'study_material';

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function study_class()
    {
        return $this->belongsTo(ClassGoupExamModel::class, 'class', 'id');
    }
    public function institute()
    {
        return $this->belongsTo(FranchiseDetails::class, 'institute_id', 'id');
    }
}
