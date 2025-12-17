<?php

namespace App\Models\NewModels;

use App\Observers\ContactQueryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

// #[ObservedBy(ContactQueryObserver::class)]
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

    public $appends = [
        'fullname',
        'mobile',
        'reason_contact',
        'message'
    ];

    public function replies()
    {
        return $this->hasMany(ContactQueryReply::class, 'contact_query_id', 'id');
    }

    public function getFullnameAttribute()
    {
        return $this->name;
    }

    public function getMobileAttribute()
    {
        return $this->phone;
    }

    public function getReasonContactAttribute()
    {
        return $this->subject;
    }

    public function getMessageAttribute()
    {
        return $this->query;
    }   
}
