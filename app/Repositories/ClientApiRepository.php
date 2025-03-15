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
        
        return DB::statement("CALL SP_UpSertClientApi(?, ?, ?, ?)", [
            null,
            $data['app_name'],
            $clientId,
            $clientSecret
        ]);
    }
    
    public static function updateClientApi($id, $data)
    {
        return DB::statement("CALL SP_UpSertClientApi(?, ?, ?, ?)", [
            $id,
            $data['app_name'],
            $data['client_id'],
            $data['client_secret']
        ]);
    }

    public static function deleteClientApi($id)
    {
        return DB::table('client_apis')->where('id', $id)->update([
            'deleted_at' => now()
        ]);
    }
}