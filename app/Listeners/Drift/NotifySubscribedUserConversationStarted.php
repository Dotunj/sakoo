<?php

namespace App\Listeners\Drift;

use App\DriftToken;
use App\Events\Drift\ConversationStarted;
use App\Services\NotifyUser;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifySubscribedUserConversationStarted implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ConversationStarted  $event
     * @return void
     */
    public function handle(ConversationStarted $event)
    {
        $driftAccount = DriftToken::whereOrganizationId($event->payload['orgId'])->first();

        $user = $driftAccount->user;

        $user->createLogEntry();

        (new NotifyUser($user))->viaSms();
    }

    public function shouldQueue(ConversationStarted $event)
    {
        $driftAccount = DriftToken::whereOrganizationId($event->payload['orgId'])->first();

        $user = $driftAccount->user;

        return ($user->subscribed('main') || $user->isStillEligibleForTrial());
    }
}
