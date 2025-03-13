<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\DB;
use Exception;

class UserService
{
    protected $userRepository;
    protected $mainLabel = "User";
    protected $messageInternalError = "Terjadi kesalahan pada server.";
    protected $messageSuccess = "User ditemukan.";

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        try {
            $users = $this->userRepository->getAllUsers();
            return ApiResponse::success($this->messageSuccess, $users);
        } catch (\Exception $e) {
            return ApiResponse::internalError($this->messageInternalError);
        }
    }

    public function getUserById($id)
    {
        try {
            $user = $this->userRepository->getUserById($id);
            if (!$user) {
                return ApiResponse::notFound($this->mainLabel." tidak ditemukan.");
            }

            return ApiResponse::success($this->messageSuccess, $user);
        } catch (\Exception $e) {
            return ApiResponse::internalError($this->messageInternalError);
        }
    }

    public function createUser($data)
    {
        DB::beginTransaction();

        try {
            $this->userRepository->createUser($data);

            DB::commit();
            return ApiResponse::success($this->mainLabel." berhasil dibuat.");
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::internalError($this->messageInternalError);
        }
    }

    public function deleteUser($id)
    {
        DB::beginTransaction();

        try {
            $user = $this->userRepository->getUserById($id);
            if (!$user) {
                return ApiResponse::notFound($this->mainLabel." tidak ditemukan.");
            }

            if (!is_null($user->deleted_at)) {
                return ApiResponse::failed($this->mainLabel." telah dihapus sebelumnya.");
            }
            
            DB::commit();
            $this->userRepository->deleteUser($id);
            return ApiResponse::success($this->mainLabel." berhasil dihapus.");
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::internalError($this->messageInternalError);
        }
    }
}