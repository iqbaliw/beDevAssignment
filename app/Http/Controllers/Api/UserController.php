<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Validation\ValidationException;
use App\Helpers\ApiResponse;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // GET /api/users
    public function index()
    {
        return $this->userService->getAllUsers();
    }

    // GET /api/users/:id
    public function show($id)
    {
        return $this->userService->getUserById($id);
    }

    // POST /api/users
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'role' => 'required|string|in:admin,user'
            ], [
                'name.required' => 'Nama wajib diisi.',
                'name.max' => 'Nama maksimal 255 karakter.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 8 karakter',
                'role.required' => 'Role wajib diisi.',
                'role.in' => 'Role harus admin atau user.'
            ]);
        } catch (ValidationException $e) {
            return ApiResponse::failed($e->errors());
        }

        return $this->userService->createUser($data);
    }

    // DELETE /api/users/:id
    public function destroy($id)
    {
        return $this->userService->deleteUser($id);
    }

    public function login()
    {
        
    }
}
