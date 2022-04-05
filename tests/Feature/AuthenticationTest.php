<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use WithFaker;

    public function test_required_field_for_registration()
    {
        $this->json('POST', 'api/register', [], ['Accept' => 'application/json'])
            ->assertStatus(422);
    }

    public function test_repeated_password_for_registration()
    {
        $data = [
            "name" => $this->faker->name(),
            "email" =>  $this->faker->unique()->safeEmail(),
            "password" => "test123"
        ];

        $this->json('POST', 'api/register', $data, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The password confirmation does not match.",
                "errors" => [
                    "password" => ["The password confirmation does not match."]
                ]
            ]);
    }

    public function test_successfull_registration()
    {
        $data = [
            "name" => $this->faker->name(),
            "email" =>  $this->faker->unique()->safeEmail(),
            "password" => "test123",
            "password_confirmation" => "test123"
        ];

        $this->json('POST', 'api/register', $data, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                'access_token',
                'token_type'
            ]);
    }

    public function test_required_field_for_login()
    {
        $this->json('POST', 'api/login', [], ['Accept' => 'application/json'])
            ->assertStatus(422);
    }

    public function test_successfull_login()
    {
        $data = [
            "email" =>  $this->faker->unique()->safeEmail(),
            "password" => "test123",
        ];

        $this->json('POST', 'api/login', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type'
            ]);
    }
}
