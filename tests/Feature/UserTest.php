<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTest extends TestCase
{
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->token = JWTAuth::fromUser($user);
    }

    public function test_user_can_add_user()
    {
        $user = User::factory()->make()->toArray();
        $user['password'] = 'rahasiadong';

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token"
        ])->postJson('/api/users', $user);

        $response->assertStatus(200)->assertJson(['message' => 'User berhasil dibuat.']);
    }

    public function test_user_can_get_all_users()
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token"
        ])->getJson('/api/users');

        $response->assertStatus(200)
        ->assertJson(['message' => 'User ditemukan.'])
        ->assertJsonStructure(['data']);
    }

    public function test_user_can_get_user_by_id()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token"
        ])->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
        ->assertJson(['message' => 'User ditemukan.'])
        ->assertJsonStructure(['data']);
    }

    public function test_user_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token"
        ])->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200)->assertJson(['message' => 'User berhasil dihapus.']);
    }
}
