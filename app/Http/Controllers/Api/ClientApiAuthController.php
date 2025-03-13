<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClientApi;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\ApiResponse;

class ClientApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $client = ClientApi::where('client_id', $request->client_id)->first();

        if (!$client || !hash_equals($client->client_secret, $request->client_secret)) {
            return ApiResponse::unauthorized("Anda belum terautentikasi.");
        }

        $token = JWTAuth::fromUser($client);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return ApiResponse::success("Anda berhasil keluar dari sistem.");
    }

    public function refresh()
    {
        try {
            return response()->json([
                'access_token' => JWTAuth::refresh(JWTAuth::getToken()),
                'token_type' => 'bearer',
                'expires_in' => auth('client')->factory()->getTTL() * 60
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenBlackListedException $e) {
            return ApiResponse::unauthorized("Token sudah tidak berlaku. Silakan login kembali.");
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ApiResponse::unauthorized("Token sudah tidak valid atau tidak tersedia.");
        }
    }
}
