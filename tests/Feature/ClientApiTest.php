<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ClientApi;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClientApiTest extends TestCase
{
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        $clientApi = ClientApi::factory()->create();
        $this->token = JWTAuth::fromUser($clientApi);
    }

    public function test_client_api_can_add_user()
    {
        $clientApi = ClientApi::factory()->make()->toArray();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token"
        ])->postJson('/api/client_api', $clientApi);

        $response->assertStatus(200)->assertJson(['message' => 'Client API berhasil dibuat.']);
    }

    public function test_client_api_can_get_all_client_apis()
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token"
        ])->getJson('/api/client_api');

        $response->assertStatus(200)
        ->assertJson(['message' => 'Client API ditemukan.'])
        ->assertJsonStructure(['data']);
    }

    public function test_client_api_can_get_client_api_by_id()
    {
        $clientApi = ClientApi::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token"
        ])->getJson("/api/client_api/{$clientApi->id}");

        $response->assertStatus(200)
        ->assertJson(['message' => 'Client API ditemukan.']);
    }

    public function test_client_api_can_update_client_api()
    {
        $clientApi = ClientApi::factory()->create();

        $dataUpdate = [
            'app_name' => fake()->name(),
            'client_id' => $clientApi->client_id,
            'client_secret' => $clientApi->client_secret
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token"
        ])->putJson("/api/client_api/{$clientApi->id}", $dataUpdate);

        $response->assertStatus(200)
        ->assertJson(['message' => 'Client API berhasil diperbarui.'])
        ->assertJsonStructure(['data']);
    }

    public function test_client_api_can_delete_client_api()
    {
        $clientApi = ClientApi::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $this->token"
        ])->deleteJson("/api/client_api/{$clientApi->id}");

        $response->assertStatus(200)->assertJson(['message' => 'Client API berhasil dihapus.']);
    }
}
