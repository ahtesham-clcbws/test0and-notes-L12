<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gn_Test_Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'test_id',
        'question_id',
        'answer',
    ];

    public function questions()
    {
        return $this->belongsTo(QuestionBankModel::class, 'question_id');
    }
}
