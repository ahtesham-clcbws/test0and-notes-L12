<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gn_PackagePlanTest extends Model
{
    use HasFactory;

    protected $table = 'gn__package_plan_tests';

    protected $fillable = [
        'gn_package_plan_id',
        'test_id',
    ];
}
