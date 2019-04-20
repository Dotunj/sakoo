<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_register()
    {
        $this->withoutExceptionHandling();

        $attributes = [
            'name' => 'Dotun Jolaoso',
            'email' => 'dotun@gmail.com',
            'password' => '123456',
        ];

        $response = $this->json('POST', route('register.user'), $attributes);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'token',
                     'user'
                 ]);
    }

    /** @test */
    public function a_user_can_login()
    {
        $this->withoutExceptionHandling();

        $attributes = [
            'email' => 'dotun@gmail.com',
            'password' => 123456,
        ];

        $user = factory(User::class)->create(['email' => 'dotun@gmail.com', 'password'=> bcrypt(123456)]);

        $response = $this->json('POST', route('login'), $attributes);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'token'
                 ]);
    }

    /** @test */
    public function an_invalid_user_cannot_login()
    {
        $attributes = [
            'email' => 'dotun@gmail.com',
            'password' => 123456,
        ];

        $response = $this->json('POST', route('login'), $attributes);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'error'
                 ]);
    }

    /** @test */
    public function a_user_needs_a_name_to_register()
    {
        $response = $this->json('POST', route('register.user'))->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function a_user_needs_an_email_to_register()
    {
        $response = $this->json('POST', route('register.user'))->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function a_user_needs_a_password_to_register()
    {
        $response = $this->json('POST', route('register.user'))->assertJsonValidationErrors(['password']);
    }
}
