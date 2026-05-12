<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestAttemptAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_attempt_id',
        'question_id',
        'answer',
        'is_visited',
        'is_marked_for_review',
    ];

    protected $casts = [
        'is_visited' => 'boolean',
        'is_marked_for_review' => 'boolean',
    ];

    public function attempt()
    {
        return $this->belongsTo(TestAttempt::class, 'test_attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(QuestionBankModel::class, 'question_id');
    }
}
