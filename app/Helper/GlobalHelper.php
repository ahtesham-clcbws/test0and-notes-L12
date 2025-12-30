<?php

use App\Models\Educationtype;
use App\Models\TestModal;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Cache;

function education_types()
{
    return Cache::remember('global_education_types', 3600, function () {
        return DB::table('education_type')->get();
    });
}

function gn_EduTypes()
{
    return Cache::remember('global_gn_edu_types', 3600, function () {
        return Educationtype::get();
    });
}

function gn_EduTest()
{
    return Cache::remember('global_gn_edu_test', 3600, function () {
        return TestModal::get();
    });
}

function classes_groups_exams()
{
    return Cache::remember('global_classes_groups_exams', 3600, function () {
        return DB::table('classes_groups_exams')->get();
    });
}

function getOtp(){
    $otp = mt_rand(100000, 999999);
    return $otp;
}
function getMobileOtp($mobileNumber){
    $otp = getOtp();
    return $otp;
}