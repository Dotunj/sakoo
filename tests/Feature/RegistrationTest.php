<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

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
}
