<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\SocialShopInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SocialShopStoreRequest;
use App\Http\Requests\SocialShopUpdateRequest;
use Illuminate\Http\Request;

class SocialShopController extends Controller
{
    private SocialShopInterface $repository;

    public function __construct(SocialShopInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $socialShop = $this->repository->socialShop();
            return $socialShop;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SocialShopStoreRequest $request)
    {
        try {
            $insertSocialShop = $this->repository->socialShopStore($request);
            return $insertSocialShop;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $showSocialShop = $this->repository->socialShopShow($id);
            return $showSocialShop;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SocialShopUpdateRequest $request, string $id)
    {
        try {
            $updateSocialShop = $this->repository->socialShopUpdate($request, $id);
            return $updateSocialShop;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deleteSocialShop = $this->repository->socialShopDelete($id);
            return $deleteSocialShop;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
