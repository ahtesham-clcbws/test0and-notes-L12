<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gn_PackagePlan extends Model
{
    use HasFactory;

    public function test()
    {
        return $this->belongsToMany(TestModal::class, 'gn__package_plan_tests', 'gn_package_plan_id', 'test_id');
    }

    public function getPublishedTestsCountAttribute(): int
    {
        return $this->test()->where('published', 1)->count();
    }

    public function getVideosCountAttribute(): int
    {
        return count(array_filter(explode(',', $this->video_id)));
    }

    public function getNotesCountAttribute(): int
    {
        return count(array_filter(explode(',', $this->study_material_id)));
    }

    public function getGkCountAttribute(): int
    {
        return count(array_filter(explode(',', $this->static_gk_id)));
    }

    // public function study_material()
    // {
    //     return $this->belongsToMany(Studymaterial::class,'select_package','id');
    // }
    public function educationType()
    {
        return $this->belongsTo(Educationtype::class, 'education_type', 'id');
    }

    public function classType()
    {
        return $this->belongsTo(ClassGoupExamModel::class, 'class', 'id');
    }
}
