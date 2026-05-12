<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestAttempt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'test_id',
        'test_attempt',
        'status',
        'is_in_review',
        'submitted_at',
        'last_section_id',
        'last_question_id',
        'draft_state',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'is_in_review' => 'boolean',
        'draft_state' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function test()
    {
        return $this->belongsTo(TestModal::class, 'test_id');
    }

    public function answers()
    {
        return $this->hasMany(TestAttemptAnswer::class);
    }
}
