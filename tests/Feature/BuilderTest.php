<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuilderTest extends TestCase
{

    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::find(1);
        $this->actingAs($user);
    }

    public function test_get_all_builder()
    {
        $this->json('GET', 'api/v1/builders', [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' =>
                [[
                    'id',
                    'name',
                    'email',
                    'phone',
                    'address',
                    'doorNo',
                    'city',
                    'state',
                    'postalCode'
                ]],
            ]);
    }
}
