<?php

namespace App\Listeners\Drift;

use App\Events\Drift\ConversationStarted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\DriftToken;
use App\Services\NotifyUser;

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
