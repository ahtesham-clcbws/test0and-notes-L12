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

    public function scopeWithRelations($query)
    {
        return $query->leftJoin("users", "users.id", "study_material.created_by")
            ->leftJoin("classes_groups_exams", "classes_groups_exams.id", "study_material.class")
            ->leftJoin("franchise_details", "franchise_details.id", "study_material.institute_id");
    }

    public function scopeByCategory($query, $categoryId)
    {
        $categories = [
            1 => 'Study Notes & E-Books',
            2 => 'Live & Video Classes',
            3 => 'Static GK & Current Affairs',
            4 => 'Comprehensive Study Material',
            5 => 'Short Notes & One Liner',
            6 => 'Premium Study Notes'
        ];

        if (collect($categories)->has($categoryId)) {
            return $query->where('category', $categories[$categoryId]);
        }
        return $query;
    }
}
