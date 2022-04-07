<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuilderTest extends TestCase
{
    use WithFaker;

    private $endpoint;
    private $header;
    private $responseDataStructure;
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::where('email', env('API_TEST_USER_NAME'))->first();
        $this->actingAs($user);

        $this->endpoint = 'api/v1/builders';
        $this->header = ['Accept' => 'application/json'];

        $this->responseDataStructure = [
            'id',
            'name',
            'email',
            'phone',
            'address',
            'address2',
            'city',
            'state',
            'postal_code'
        ];
    }

    public function test_validation_error_when_send_empty_payload()
    {
        $response = $this->postJson($this->endpoint, [], $this->header);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'phone', 'address', 'city', 'postal_code']);
    }

    public function test_authenticated_user_can_post_builder()
    {
        $payload = Builder::factory()->make()->toArray();

        $response = $this->postJson($this->endpoint, $payload, $this->header);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => $this->responseDataStructure
            ])
            ->assertJson([
                'data' => $payload
            ]);
    }

    public function test_authenticated_user_can_update_builder()
    {
        $payload = Builder::factory()->make()->toArray();
        $builder = Builder::first();

        $response = $this->putJson("{$this->endpoint}/$builder->id", $payload, $this->header);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => $this->responseDataStructure
            ])
            ->assertJson([
                'data' => $payload
            ]);
    }

    public function test_return_authenticated_user_can_get_builders_list()
    {
        $response = $this->getJson($this->endpoint, $this->header);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [$this->responseDataStructure],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'links',
                    'path',
                    'per_page',
                    'to',
                    'total'
                ]
            ]);
    }

    public function test_return_authenticated_user_can_get_builders_list_with_divisions()
    {
        $response = $this->getJson("{$this->endpoint}/?includeDivisions=true", $this->header);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' =>
                [[
                    'id',
                    'name',
                    'email',
                    'phone',
                    'address',
                    'address2',
                    'city',
                    'state',
                    'postal_code',
                    'divisions' =>
                    [[
                        'id',
                        'name',
                        'state',
                        'latitude',
                        'longitude'
                    ]]
                ]],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'links',
                    'path',
                    'per_page',
                    'to',
                    'total'
                ]
            ]);
    }

    public function test_return_authenticated_user_can_get_builder_details()
    {
        $response = $this->getJson("{$this->endpoint}/1", $this->header);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->responseDataStructure,
            ]);
    }

    public function test_non_authenticated_user_cannot_get_builder_details()
    {
        Auth::guard()->logout();
        $response = $this->getJson("{$this->endpoint}/1", $this->header);

        $response
            ->assertStatus(401)
            ->assertSee('Unauthenticated.');
    }
}
