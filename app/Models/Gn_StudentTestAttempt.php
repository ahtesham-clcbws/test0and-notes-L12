<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gn_StudentTestAttempt extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'gn__student_test_attempts';

    protected $fillable = [
        'student_id',
        'test_id',
        'test_attempt',
    ];

    public function test()
    {
        return $this->belongsTo(TestModal::class, 'test_id', 'id');
    }
}
