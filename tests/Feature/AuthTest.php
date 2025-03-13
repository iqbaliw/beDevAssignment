<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    protected $emailUser = 'iqbalwahyudi20@gmail.com';
    protected $passwordUser = 'rahasia2025';

    public function test_user_can_login_and_get_jwt_token()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->emailUser,
            'password' => $this->passwordUser
        ]);

        $response->assertStatus(200)->assertJsonStructure(['access_token']);
    }

    public function test_user_can_logout()
    {
        $user = User::where('email', $this->emailUser)->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->postJson('/api/logout');

        $response->assertStatus(200)->assertJson(['message' => 'Anda berhasil keluar dari sistem.']);
    }

    public function test_user_can_refresh_token()
    {
        $user = User::where('email', $this->emailUser)->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->postJson('/api/refresh');

        $response->assertStatus(200)->assertJsonStructure(['access_token']);
    }
}
