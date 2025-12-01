<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateEnquiryReply extends Model
{
    use HasFactory;
    protected $fillable = [
        'corporate_enquiry_id',
        'type',
        'message',
        'user_id'
    ];
}
