<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    public function state_data() {
        return $this->hasManyThrough(CorporateEnquiry::class, UserDetails::class, City::class);
    }
}
