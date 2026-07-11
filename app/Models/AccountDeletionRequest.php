<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountDeletionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'mobile',
        'delete_all_data',
        'backup_data',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'delete_all_data' => 'boolean',
        'backup_data' => 'boolean',
        'completed_at' => 'datetime',
    ];
}
