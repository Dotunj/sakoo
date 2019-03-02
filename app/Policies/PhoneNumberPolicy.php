<?php

namespace App\Policies;

use App\User;
use App\PhoneNumber;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhoneNumberPolicy
{
    use HandlesAuthorization;

    public function touch(User $user, PhoneNumber $phoneNumber)
    {
        return $user->id === $phoneNumber->user_id;
    }

}
