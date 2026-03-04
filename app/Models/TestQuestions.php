<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestQuestions extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'test_questions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'test_id',
        'section_id',
        'creator_id',
        'question_id',
        'allotter_id',
    ];

    public function fromTest()
    {
        return $this->belongsTo(TestModal::class, 'test_id', 'id');
    }

    public function forSection()
    {
        return $this->belongsTo(TestSections::class, 'section_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo(QuestionBankModel::class, 'question_id', 'id');
    }

    public function alloted_by()
    {
        return $this->belongsTo(User::class, 'allotter_id', 'id');
    }

    public function question_creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public $timestamps = true;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    const DELETED_AT = 'deleted_at';
}
