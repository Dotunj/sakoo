<?php

namespace App\Listeners\Drift;

use App\Events\Drift\ConversationStarted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\DriftToken;

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
        $user = DriftToken::whereOrganizationId($event->payload['orgId'])->first();

        $user->createLogEntry();

        $user->notify(new SMSNotification());
    }
}
