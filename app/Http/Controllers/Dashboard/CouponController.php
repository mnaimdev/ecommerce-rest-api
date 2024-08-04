<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\CouponInterface;
use App\Enums\CouponCustomerEnum;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponStoreRequest;
use App\Http\Requests\CouponUpdateRequest;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    private CouponInterface $repository;

    public function __construct(CouponInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $coupon = $this->repository->coupon();
            return $coupon;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponStoreRequest $request)
    {
        try {
            $insertCoupon = $this->repository->couponStore($request);
            return $insertCoupon;
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
            $showCoupon = $this->repository->couponShow($id);
            return $showCoupon;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponUpdateRequest $request, string $id)
    {
        try {
            $updateCoupon = $this->repository->couponUpdate($request, $id);
            return $updateCoupon;
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
            $deleteCoupon = $this->repository->couponDelete($id);
            return $deleteCoupon;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
