<?php

namespace App\Models\NewModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ContactQuery extends Model
{
    use Notifiable;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'city',
        'subject',
        'query',
        'isNew'
    ];

    public $casts = ['isNew' => 'boolean'];


    public function replies()
    {
        return $this->hasMany(ContactQueryReply::class, 'contact_query_id', 'id');
    }
}
