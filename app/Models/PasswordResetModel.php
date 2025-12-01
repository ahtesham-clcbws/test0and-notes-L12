<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordResetModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'passwordresets';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'user_id',
        'user_type',
        'verify_type',
        'code',
        'status'
    ];
    
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';
}
