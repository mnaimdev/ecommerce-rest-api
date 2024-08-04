<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\UserAuthInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAuthLoginRequest;
use App\Http\Requests\UserAuthRegisterRequest;
use Illuminate\Http\Request;

class AdminAuthenticationController extends Controller
{
    private UserAuthInterface $repository;

    function __construct(UserAuthInterface $repository)
    {
        $this->repository = $repository;
    }

    public function userRegister(UserAuthRegisterRequest $request)
    {
        try {
            $user = $this->repository->userRegisterProcess($request);
            return $user;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function userLogin(UserAuthLoginRequest $request)
    {
        try {
            $user = $this->repository->userLoginProcess($request);
            return $user;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function userLogout(Request $request)
    {
        try {
            $logout = $this->repository->userLogoutProcess($request);
            return $logout;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function userInfo(Request $request)
    {
        try {
            $userInfo = $this->repository->userInfo($request);
            return $userInfo;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function userProfileUpdate(Request $request)
    {
        try {
            $userProfileUpdate = $this->repository->userProfileUpdate($request);
            return $userProfileUpdate;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
