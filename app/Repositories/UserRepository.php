<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserRepository
{
    public static function getAllUsers()
    {
        return DB::table('users')->get();
    }

    public static function getUserById($id)
    {
        return DB::table('users')->where('id', $id)->first();
    }

    public static function createUser($data)
    {
        return DB::table('users')->insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'created_at' => now()
        ]);
    }

    public static function deleteUser($id)
    {
        return DB::table('users')->where('id', $id)->update([
            'deleted_at' => now()
        ]);
    }
}