<?php

use App\Models\Educationtype;
use App\Models\TestModal;
use Illuminate\Support\Facades\DB;

function education_types()
{
    return DB::table('education_type')->get();
}

function gn_EduTypes()
{
    return Educationtype::get();
}

function gn_EduTest()
{
    return TestModal::get();
}

function classes_groups_exams()
{
    return DB::table('classes_groups_exams')->get();
}
