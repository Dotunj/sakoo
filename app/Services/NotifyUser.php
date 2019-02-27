<?php

namespace App\Services;

use App\Services\Twilio;


class NotifyUser
{
    protected $user;

    protected $twilio;

    public function __construct($user)
    {
        $this->user = $user;

        $this->twilio = new Twilio();
    }

    public function viaSms()
    {
        $phoneNumbers = $this->user->phoneNumbers;

        foreach($phoneNumbers as $phoneNumber){
            $this->twilio->notify($phoneNumber->number);
        }

        return $this;
    }


}
