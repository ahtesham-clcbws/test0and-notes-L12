<?php

use App\Models\BoardAgencyStateModel;
use App\Models\City;
use App\Models\ClassGoupExamModel;
use App\Models\CorporateEnquiry;
use App\Models\DefautlOtpNumber;
use App\Models\OtherCategoryClass;
use App\Models\State;
use App\Models\Subject;
use App\Models\SubjectPart;
use App\Models\SubjectPartLesson;
use App\Models\User;

function franchiseTypes()
{
    $institutionTypes = [
        array("id" => 0, "name" => "Kids School (PG - 5th)"),
        array("id" => 0, "name" => "Primary School (5th - 8th)"),
        array("id" => 0, "name" => "Senior School (PG - 12th)"),
        array("id" => 0, "name" => "4th - 8th (Coaching Class)"),
        array("id" => 0, "name" => "9th - 12th (Coaching Class)"),
        array("id" => 0, "name" => "12th+ (Academic/Pre Exams)"),
        array("id" => 0, "name" => "Engg/Medical Pre Exams"),
        array("id" => 0, "name" => "SSC/Bank/ State Govt Exams"),
        array("id" => 0, "name" => "IAS/PCS (Civil Service Exams)"),
        array("id" => 0, "name" => "Other Pre Exams/Govt Exams")
    ];
    return $institutionTypes;
}
function corporateInterests()
{
    $institutionInterested = [
        array("id" => 0, "name" => "Online Test (Web & Mobile App)"),
        array("id" => 0, "name" => "Offline Test (At Centers/Schools )"),
        array("id" => 0, "name" => "Video & Live Classes (Online)"),
        array("id" => 0, "name" => "Study Notes (PDF/E-Books)"),
        array("id" => 0, "name" => "Study Notes (Book/Paper Notes)"),
        array("id" => 0, "name" => "Publication/Book Store"),
        array("id" => 0, "name" => "ESchool/Institute (Training Program)"),
        array("id" => 0, "name" => "School (Management & Consultation)"),
        array("id" => 0, "name" => "School/Institute (Branding & Fame)"),
        array("id" => 0, "name" => "School/Institute (Students Strength)")
    ];
    return $institutionInterested;
}
function getStates()
{
    return State::all();
}
function getCitiesByState($stateid)
{
    $cities = City::select('id', 'name')->where('state_id', $stateid)->get();
    return json_encode($cities);
}
function generateBranchCode($name)
{
    $date = date('YmdHis', time());
    $time = substr($date, 6, 13);
    // $time = $date;
    $explode = explode(' ', $name);
    $strName = '';
    foreach ($explode as $key => $ss) {
        if ($key < 3) {
            $strName .= ucwords(substr($ss, 0, 1));
        }
    }
    $count = count($explode);
    if ($count >= 3) {
        $strName .= $time;
    }
    if ($count == 2) {
        $strName .= 'S' . $time;
    }
    if ($count == 1) {
        $strName .= 'SS' . $time;
    }
    return $strName;
}
function getClassesByEducation($educationId)
{
    return ClassGoupExamModel::where('education_type_id', $educationId)->get();
}
function getBoardsbyClass($boards)
{
    $boards_agency_state = explode(',', $boards);
    $boardsArray = array();
    foreach ($boards_agency_state as $key => $value) {
        $board = BoardAgencyStateModel::find($value);
        array_push($boardsArray, $board);
    }
    return $boardsArray;
}
function getSubjectPartsBySubject($subjectId)
{
    return Subject::find($subjectId)->subject_parts();
}
function getSubjectPartLessonsBySubject($subjectId)
{
    return Subject::find($subjectId)->subject_part_lessons();
}
function getSubjectPartLessonsBySubjectPart($subjectPartId)
{
    return SubjectPart::find($subjectPartId)->subject_part_lessons();
}
function testOtherCategory()
{
    return OtherCategoryClass::get();
}
////////////////////////
function getSubjectPartsBySubject2($subjectId)
{
    return SubjectPart::where('subject_id', $subjectId)->get();
}
function getSubjectPartLessonsBySubjectPart2($subjectPartId)
{
    return SubjectPartLesson::where('subject_part_id', $subjectPartId)->get();
}
function sendEmail($emailto, $subject, $message)
{

}
function defaultNumberCheck($mobile)
{
    $data = DefautlOtpNumber::where('mobile', $mobile)->first();
    if ($data) {
        return true;
    }
    return false;
}
function numberInUse($mobile)
{
    if (User::where('mobile', $mobile)->first()) {
        return true;
    }
    if (CorporateEnquiry::where('mobile', $mobile)->first()) {
        return true;
    }
    return false;
}
function sendSMS($mobileNumber, $message){
    $message    = rawurlencode($message);
    $apikey     = urlencode("MzQ0YzZhMzU2ZTY2NjI0YjU4Mzc0NDMxNmU3MjYzNmM=");
    $sender     = urlencode("GYNLGY");
    $url        = 'https://api.textlocal.in/send/?apikey='. $apikey .'&numbers='. $mobileNumber ."&sender=". $sender ."&message=". $message;
    $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            if($response === false) {     echo 'Curl error: ' . curl_error($ch); }
            curl_close($ch);
            $response = json_decode($response);
}