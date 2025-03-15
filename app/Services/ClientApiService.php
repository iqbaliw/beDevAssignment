<?php

namespace App\Services;

use App\Repositories\ClientApiRepository;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\DB;
use Exception;

class ClientApiService
{
    protected $clientApiRepository;
    protected $mainLabel = "Client API";
    protected $messageInternalError = "Terjadi kesalahan pada server.";
    protected $messageSuccess = "Client API ditemukan.";

    public function __construct(ClientApiRepository $clientApiRepository)
    {
        $this->clientApiRepository = $clientApiRepository;
    }

    public function getAllClientApis()
    {
        try {
            $clientApis = $this->clientApiRepository->getAllClientApis();

            return ApiResponse::success($this->messageSuccess, $clientApis);
        } catch (\Exception $e) {
            return ApiResponse::internalError($this->messageInternalError);
        }
    }

    public function getClientApiById($id)
    {
        try {
            $clientApi = $this->clientApiRepository->getClientApiById($id);
            if (!$clientApi) {
                return ApiResponse::notFound($this->mainLabel." tidak ditemukan.");
            }

            return ApiResponse::success($this->messageSuccess, $clientApi);
        } catch (\Exception $e) {
            return ApiResponse::internalError($this->messageInternalError);
        }
    }

    public function createClientApi($data)
    {
        DB::beginTransaction();

        try {
            $this->clientApiRepository->createClientApi($data);

            DB::commit();
            return ApiResponse::success($this->mainLabel." berhasil dibuat.");
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::internalError($this->messageInternalError);
        }
    }

    public function updateClientApi($id, $data)
    {
        DB::beginTransaction();

        try {
            $clientApi = $this->clientApiRepository->getClientApiById($id);
            if (!$clientApi) {
                return ApiResponse::notFound($this->mainLabel." tidak ditemukan.");
            }

            if (!is_null($clientApi->deleted_at)) {
                return ApiResponse::failed($this->mainLabel." telah dihapus sebelumnya.");
            }
            
            DB::commit();
            $this->clientApiRepository->updateClientApi($id, $data);
            return ApiResponse::success($this->mainLabel." berhasil diperbarui.");
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::internalError($e->getMessage());
        }
    }

    public function deleteClientApi($id)
    {
        DB::beginTransaction();

        try {
            $clientApi = $this->clientApiRepository->getClientApiById($id);
            if (!$clientApi) {
                return ApiResponse::notFound($this->mainLabel." tidak ditemukan.");
            }

            if (!is_null($clientApi->deleted_at)) {
                return ApiResponse::failed($this->mainLabel." telah dihapus sebelumnya.");
            }
            
            $this->clientApiRepository->deleteClientApi($id);

            DB::commit();
            return ApiResponse::success($this->mainLabel." berhasil dihapus.");
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::internalError($this->messageInternalError);
        }
    }
}