<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gn_PackagePlan extends Model
{
    use HasFactory;

    public function test()
    {
        return $this->belongsToMany(TestModal::class,'gn__package_plan_tests','gn_package_plan_id','test_id');
    }
    
    // public function study_material()
    // {
    //     return $this->belongsToMany(Studymaterial::class,'select_package','id');
    // }
}
