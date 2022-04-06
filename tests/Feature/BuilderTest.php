<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Builder;
use Laravel\Sanctum\Sanctum;
use Database\Factories\BuilderFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuilderTest extends TestCase
{

    use WithFaker;

    private $endpoint;
    private $jsonDataStructure;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::first();
        $this->actingAs($user);

        $this->endpoint = 'api/v1/builders';

        $this->jsonDataStructure = [
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

    public function test_get_all_builder()
    {
        $this->json('GET', $this->endpoint, [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [$this->jsonDataStructure],
            ]);
    }

    public function test_get_all_builder_with_division()
    {
        $this->json('GET', "{$this->endpoint}/?includeDivisions=true", [], ['Accept' => 'application/json'])
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
            ]);
    }

    public function test_get_builder_details()
    {
        $this->json('GET', "{$this->endpoint}/1", [], ['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => $this->jsonDataStructure,
        ]);

    }

    public function test_post_required_field_for_builder()
    {
        $this->json('POST', $this->endpoint, [], ['Accept' => 'application/json'])
        ->assertStatus(422);
    }

    public function test_post_successfull_builder()
    {
        $data = Builder::factory()->create()->toArray();
        
        $this->json('POST', $this->endpoint, $data, ['Accept' => 'application/json'])
        ->assertStatus(201)
        ->assertJsonStructure([
            'data' => $this->jsonDataStructure,
        ]);
    }

    public function test_put_successfull_builder()
    {
        $data = Builder::factory()->create()->toArray();

        $builder = Builder::find(2);

        $this->json('PUT', "{$this->endpoint}/$builder->id", $data, ['Accept' => 'application/json'])
        ->assertStatus(200);
    }
}
