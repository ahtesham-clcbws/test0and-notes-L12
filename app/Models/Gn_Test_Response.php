<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gn_Test_Response extends Model
{
    use HasFactory;

    public function questions()
    {
        $this->belongsTo(QuestionBankModel::class,'question_id');
    }
}
