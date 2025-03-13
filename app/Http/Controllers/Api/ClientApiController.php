<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ClientApiService;
use Illuminate\Validation\ValidationException;
use App\Helpers\ApiResponse;


class ClientApiController extends Controller
{
    protected $clientApiService;

    public function __construct(ClientApiService $clientApiService)
    {
        $this->clientApiService = $clientApiService;
    }

    // GET /api/client_api
    public function index()
    {
        return $this->clientApiService->getAllClientApis();
    }

    // GET /api/client_api/:id
    public function show($id)
    {
        return $this->clientApiService->getClientApiById($id);
    }

    // POST /api/client_api
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'app_name' => 'required|string|max:255|unique:client_apis,app_name',
            ], [
                'app_name.required' => 'Nama aplikasi wajib diisi.',
                'app_name.unique' => 'Nama aplikasi sudah terdaftar.',
                'app_name.max' => 'Nama aplikasi maksimal 255 karakter.',
            ]);
        } catch (ValidationException $e) {
            return ApiResponse::failed($e->errors());
        }

        return $this->clientApiService->createClientApi($data);
    }
    
    // PUT /api/client_api
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'app_name' => 'required|string|max:255|unique:client_apis,app_name,'.$id,
                'client_id' => 'required|string|unique:client_apis,client_id,'.$id,
                'client_secret' => 'required|string|unique:client_apis,client_secret,'.$id
            ], [
                'app_name.required' => 'Nama aplikasi wajib diisi.',
                'app_name.unique' => 'Nama aplikasi sudah terdaftar.',
                'app_name.max' => 'Nama aplikasi maksimal 255 karakter.',
                'client_id.required' => 'Client ID wajib diisi.',
                'app_client_id.unique' => 'Client ID sudah terdaftar.',
                'client_secret.required' => 'Client Secret wajib diisi.',
                'client_secret.unique' => 'Client Secret sudah terdaftar.',
            ]);
        } catch (ValidationException $e) {
            return ApiResponse::failed($e->errors());
        }

        return $this->clientApiService->updateClientApi($id, $data);
    }

    // DELETE /api/client_api/:id
    public function destroy($id)
    {
        return $this->clientApiService->deleteClientApi($id);
    }
}
