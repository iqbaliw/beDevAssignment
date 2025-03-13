<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;

class ClientApiRepository
{
    public static function getAllClientApis()
    {
        return DB::table('client_apis')->get();
    }

    public static function getClientApiById($id)
    {
        return DB::table('client_apis')->where('id', $id)->first();
    }

    public static function createClientApi($data)
    {
        $clientId = Str::uuid();
        $clientSecret = Hash::make($clientId);
        
        return DB::table('client_apis')->insert([
            'app_name' => $data['app_name'],
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'created_at' => now()
        ]);
    }
    
    public static function updateClientApi($id, $data)
    {
        return DB::table('client_apis')->where('id', $id)->update([
            'app_name' => $data['app_name'],
            'client_id' => $data['client_id'],
            'client_secret' => $data['client_secret'],
            'updated_at' => now()
        ]);
    }

    public static function deleteClientApi($id)
    {
        return DB::table('client_apis')->where('id', $id)->update([
            'deleted_at' => now()
        ]);
    }
}