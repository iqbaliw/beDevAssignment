<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ClientApi;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthClientTest extends TestCase
{
    protected $clientId = '472ea056-8360-4d79-9801-422beb765d92';
    protected $clientSecret = '$2y$12$149tTP8YdqsK2ezFRUXt4.Tvh8uPhTmD0jJiMUyu2rygOvsiOGaG6';

    public function test_client_can_login_and_get_jwt_token()
    {
        $response = $this->postJson('/api/client/login', [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret
        ]);

        $response->assertStatus(200)->assertJsonStructure(['access_token']);
    }

    public function test_client_can_logout()
    {
        $client = ClientApi::where('client_id', $this->clientId)->first();

        $token = JWTAuth::fromUser($client);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->postJson('/api/client/logout');

        $response->assertStatus(200)->assertJson(['message' => 'Anda berhasil keluar dari sistem.']);
    }

    public function test_client_can_refresh_token()
    {
        $client = ClientApi::where('client_id', $this->clientId)->first();

        $token = JWTAuth::fromUser($client);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->postJson('/api/client/refresh');

        $response->assertStatus(200)->assertJsonStructure(['access_token']);
    }
}
