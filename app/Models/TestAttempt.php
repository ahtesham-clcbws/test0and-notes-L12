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

    /**
     * Check if a running test attempt has expired based on its duration.
     * If expired, update status to completed and set submitted_at to now.
     * Returns true if the attempt was running and is now expired/completed.
     */
    public function checkAndHandleExpiry(): bool
    {
        if ($this->status !== 'running') {
            return false;
        }

        $test = $this->test;
        if (! $test) {
            return false;
        }

        $totalDuration = $test->time_to_complete;
        if (! $totalDuration) {
            // Calculate total duration from sections if time_to_complete is not set
            $section_time = $test->testSections()
                ->select('number_of_questions', 'duration')
                ->get()
                ->toArray();

            $timeArray = [];
            foreach ($section_time as $section) {
                $timeArray[] = ($section['number_of_questions'] ?? 0) * ($section['duration'] ?? 0);
            }
            $totalDuration = array_sum($timeArray);
        }

        if (! $totalDuration || $totalDuration <= 0) {
            $totalDuration = 60; // 60 minutes default
        }

        $expiryTime = $this->created_at->timestamp + ($totalDuration * 60);
        if (now()->timestamp >= $expiryTime) {
            $this->update([
                'status' => 'completed',
                'submitted_at' => now(),
            ]);

            return true;
        }

        return false;
    }
}
