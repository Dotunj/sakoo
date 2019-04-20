<?php

namespace App\Policies;

use App\PhoneNumber;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhoneNumberPolicy
{
    use HandlesAuthorization;

    public function touch(User $user, PhoneNumber $phoneNumber)
    {
        return $user->id == $phoneNumber->user_id;
    }
}
