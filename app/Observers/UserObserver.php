<?php

namespace App\Observers;

use App\Models\User;
use Faker\Provider\Uuid;

class UserObserver
{

    /**
     * Handle the User "created" event.
     */
    public function creating(User $user): void
    {
        $user->id = Uuid::uuid();
    }
}
