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
        $hashedPassword = Hash::make($data['password']);
            
        return DB::statement("CALL SP_UpSertUser(?, ?, ?, ?, ?)", [
            null,
            $data['name'],
            $data['email'],
            $data['role'],
            $hashedPassword
        ]);
    }

    public static function deleteUser($id)
    {
        return DB::table('users')->where('id', $id)->update([
            'deleted_at' => now()
        ]);
    }
}