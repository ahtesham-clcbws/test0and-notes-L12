<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseDetail extends Model
{
    use HasFactory;
    protected $table = 'course_details';
    protected $primaryKey = 'id';

    protected $fillable = [
        'course_full_name',
        'course_short_name',
        'course_image',
        'description',
        'notification_image',
        'exam_detail',
        'free_study_note',
        'previous_papers',
        'notification_data',
        'registration',
        'exam_date',
        'exam_mode',
        'vacancies',
        'eligibility',
        'salary',
        'official_site',
    ];
}
