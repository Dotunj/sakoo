<?php

namespace Tests\Feature;

use App\PhoneNumber;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhoneNumberTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_unauthenticated_user_cannot_add_a_phone_number()
    {
        $attributes = factory(PhoneNumber::class)->raw();

        $response = $this->json('POST', route('create.phone.number'));

        $response->assertStatus(401);
    }

    /** @test */
    public function a_user_can_add_a_phone_number()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $attributes = factory(PhoneNumber::class)->raw();

        $response = $this->json('POST', route('create.phone.number'), $attributes);

        $response->assertStatus(201)
               ->assertJsonStructure([
                   'status',
                   'data'
               ]);

        $this->assertDatabaseHas('phone_numbers', $attributes);
    }

    /** @test */
    public function a_user_can_edit_a_phone_number()
    {
        $user = $this->signIn();

        $number = factory(PhoneNumber::class)->create(['user_id' => $user->id]);

        $response = $this->json('GET', route('edit.phone.number', $number));

        $response->assertStatus(200)
               ->assertJsonStructure([
                   'status',
                   'data'
               ]);
    }

    /** @test */
    public function a_user_can_update_a_phone_number()
    {
        $user = $this->signIn();

        $number = factory(PhoneNumber::class)->create(['user_id' => $user->id]);

        $attributes = [
            'number' => +23456789212,
            'notification_on' => false
        ];

        $response = $this->json('PUT', route('update.phone.number', $number), $attributes);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'data'
                ]);

        $this->assertDatabaseHas('phone_numbers', $attributes);
    }

    /** @test */
    public function a_user_can_delete_a_phone_number()
    {
        $user = $this->signIn();

        $number = factory(PhoneNumber::class)->create(['user_id' => $user->id]);

        $response = $this->json('DELETE', route('delete.phone.number', $number));

        $response->assertStatus(200)
             ->assertJsonStructure([
                 'status',
                 'message'
             ]);
    }

    /** @test */
    public function a_user_cannot_edit_another_users_phone_number()
    {
        $user1 = factory(User::class)->create();

        $user2 = factory(User::class)->create();

        $number = factory(PhoneNumber::class)->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->json('GET', route('edit.phone.number', $number));

        $response->assertStatus(403);
    }

    /** @test */
    public function a_user_needs_a_phone_number_to_create_one()
    {
        $user = $this->signIn();

        $this->json('POST', route('create.phone.number'))->assertJsonValidationErrors(['number']);
    }
}
