<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignClassBoardModel extends Model
{
    use HasFactory;

    protected $table = 'assign_classes_boards';
    protected $primaryKey = 'id';

    protected $fillable = [
        'class_id',
        'board_id'
    ];
}
