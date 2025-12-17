<?php

namespace App\Models\NewModels;

use Illuminate\Database\Eloquent\Model;

class ContactQueryReply extends Model
{
    protected $fillable = [
        'contact_query_id',
        'message'
    ];

    public function contact_query()
    {
        return $this->belongsTo(ContactQuery::class);
    }
}
