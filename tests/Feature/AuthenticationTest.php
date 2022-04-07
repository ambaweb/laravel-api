<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use WithFaker;

    private $header;

    public function setUp(): void
    {
        parent::setUp();

        $this->header = ['Accept' => 'application/json'];
    }

    public function test_validation_error_when_send_empty_payload_for_registration()
    {
        $response = $this->postJson('api/register', [], $this->header);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_validation_error_when_confirm_password_not_matched_for_registration()
    {
        $payload = [
            'name' => $this->faker->name(),
            'email' =>  $this->faker->unique()->safeEmail(),
            'password' => env('API_TEST_USER_PASSWORD'),
        ];

        $response = $this->postJson('api/register', $payload, $this->header);

        $response
            ->assertStatus(422)
            ->assertJson([
                "message" => "The password confirmation does not match.",
                "errors" => [
                    "password" => ["The password confirmation does not match."]
                ]
            ]);
    }

    public function test_validation_error_when_email_already_taken_for_registration()
    {
        $payload = [
            'name' => $this->faker->name(),
            'email' =>  env('API_TEST_USER_NAME'),
            'password' => env('API_TEST_USER_PASSWORD'),
            'password_confirmation' => env('API_TEST_USER_PASSWORD'),
        ];

        $response = $this->postJson('api/register', $payload, $this->header);

        $response
            ->assertStatus(422)
            ->assertJson([
                "message" => "The email has already been taken.",
                "errors" => [
                    "email" => ["The email has already been taken."]
                ]
            ]);
    }

    public function test_user_successfull_registration()
    {
        $payload = [
            'name' => $this->faker->name(),
            'email' =>  $this->faker->unique()->safeEmail(),
            'password' => 'test123',
            'password_confirmation' => 'test123'
        ];

        $response = $this->postJson('api/register', $payload, $this->header);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'access_token',
                'token_type'
            ]);
    }

    public function test_validation_error_when_both_fields_empty_for_login()
    {
        $payload = [];

        $response = $this->postJson('api/login', $payload, $this->header);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_validation_error_on_email_when_credential_donot_match()
    {
        $payload = [
            'email' =>  $this->faker->unique()->safeEmail(),
            'password' => 'test123456'
        ];

        $response = $this->postJson('api/login', $payload, $this->header);

        $response
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated']);
    }

    public function test_return_user_token_after_successful_login()
    {
        $payload = [
            'email' =>  env('API_TEST_USER_NAME'),
            'password' => env('API_TEST_USER_PASSWORD'),
        ];

        $response = $this->postJson('api/login', $payload, $this->header);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type'
            ]);
    }
}
