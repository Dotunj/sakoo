<?php

namespace Tests\Unit;

use App\LogEntry;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function a_user_can_have_many_drift_accounts()
    {
        $this->assertInstanceOf(Collection::class, $this->user->drift);
    }

    /** @test */
    public function a_user_can_have_many_phone_numbers()
    {
        $this->assertInstanceOf(Collection::class, $this->user->phoneNumbers);
    }

    /** @test */
    public function a_user_can_have_many_log_entries()
    {
        $this->assertInstanceOf(Collection::class, $this->user->logEntry);
    }

    /** @test */
    public function a_user_can_create_a_log_entry()
    {
        $this->user->createLogEntry();

        $this->assertEquals(1, $this->user->successfulLogEntriesCount());
    }

    /** @test */
    public function determine_the_number_of_successful_log_entries_a_user_has()
    {
        factory(LogEntry::class, 10)->create(['user_id' => $this->user->id, 'status'=> true]);

        $this->assertEquals(10, $this->user->successfulLogEntriesCount());
    }

    /** @test */
    public function determine_the_number_of_sms_messages_a_user_has_received_today()
    {
        factory(LogEntry::class, 10)->create(['user_id' => $this->user->id, 'status' => true]);

        $this->assertEquals(10, $this->user->notifications_sent_today);
    }
}
