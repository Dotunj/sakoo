<?php

namespace Tests\Feature;

use App\Jobs\SendTrialEmail;
use App\LogEntry;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SendTrialReminderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_send_an_email_when_your_trial_is_about_to_expire()
    {
        Queue::fake();

        $user = factory(User::class)->create();

        factory(LogEntry::class, 18)->create(['user_id' => $user->id, 'status' => true]);

        $this->artisan('trial-emails-send');

        Queue::assertPushed(SendTrialEmail::class, function ($job) use ($user) {
            return $job->user->id === $user->id;
        });
    }

    /** @test */
    public function it_does_not_send_an_email_when_your_trial_is_not_about_to_expire()
    {
        Queue::fake();

        $user = factory(User::class)->create();

        factory(LogEntry::class, 10)->create(['user_id' => $user->id, 'status' => true]);

        $this->artisan('trial-emails-send');

        Queue::assertNotPushed(SendTrialEmail::class);
    }
}
