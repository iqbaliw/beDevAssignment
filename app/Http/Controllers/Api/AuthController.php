<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\ApiResponse;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return ApiResponse::unauthorized("Anda belum terautentikasi.");
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return ApiResponse::success("Anda berhasil keluar dari sistem.");
    }

    public function refresh()
    {
        try {
            return response()->json([
                'access_token' => Auth::refresh(),
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenBlackListedException $e) {
            return ApiResponse::unauthorized("Token sudah tidak berlaku. Silakan login kembali.");
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ApiResponse::unauthorized("Token tidak valid atau tidak tersedia.");
        }
    }
}
