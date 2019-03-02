<?php

namespace App\Services;

use App\User;
use App\Jobs\SendTrialEmail;

class TrialAboutToExpire
{
    public function __construct()
    {
        $this->users = User::usersYetToSubscribe();
    }

    /**
     * returns all the users who we have 
     * sent more than 18 SMS and are not 
     * subscribed yet
     */
    public function usersTrialDueToExpire()
    {
       $users = $this->users->filter(function($user) {
           return $user->successfulLogEntriesCount() <= 18;
       });

        return $users;
    }

    public function sendEmail()
    {
        $users = $this->usersTrialDueToExpire();

        if($users->count() > 0){
            $users->each(function($user){
                dispatch(new SendTrialEmail($user));
            });
        }

        return;
    }

}
