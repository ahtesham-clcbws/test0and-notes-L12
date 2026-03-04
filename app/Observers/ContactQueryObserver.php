<?php

namespace App\Observers;

use App\Models\NewModels\ContactQuery;
use App\Models\User;
use App\Notifications\ContactQueryAdminMail;

class ContactQueryObserver
{
    /**
     * Handle the ContactQuery "created" event.
     */
    public function created(ContactQuery $contactQuery): void
    {
        // $adminUser = User::where('email', 'ahtesham2000@gmail.com')->first();
        // $adminUsers = User::whereIn('roles', ['superadmin', 'admin'])->get();
        // if (count($adminUsers)) {
        //     foreach ($adminUsers as $adminUser) {
        //         $adminUser->notify(new ContactQueryAdminMail($contactQuery));
        //     }
        // }
    }

    /**
     * Handle the ContactQuery "updated" event.
     */
    public function updated(ContactQuery $contactQuery): void
    {
        //
    }

    /**
     * Handle the ContactQuery "deleted" event.
     */
    public function deleted(ContactQuery $contactQuery): void
    {
        //
    }

    /**
     * Handle the ContactQuery "restored" event.
     */
    public function restored(ContactQuery $contactQuery): void
    {
        //
    }

    /**
     * Handle the ContactQuery "force deleted" event.
     */
    public function forceDeleted(ContactQuery $contactQuery): void
    {
        //
    }
}
