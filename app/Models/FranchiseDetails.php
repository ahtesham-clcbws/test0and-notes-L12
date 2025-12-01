<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FranchiseDetails extends Model
{
    use HasFactory, SoftDeletes;
    public function corporate(){
        return $this->hasOne(CorporateEnquiry::class, 'id', 'enquiry_id');
    }

    public function test()
    {
        return $this->hasMany(TestModal::class, 'user_id', 'user_id');
    }
}
