<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\CouponConditionInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponConditionStoreRequest;
use App\Http\Requests\CouponConditionUpdateRequest;
use Illuminate\Http\Request;

class CouponConditionController extends Controller
{
    private CouponConditionInterface $repository;

    public function __construct(CouponConditionInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $couponCondition = $this->repository->couponCondition();
            return $couponCondition;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponConditionStoreRequest $request)
    {
        try {
            $insertCouponCondition = $this->repository->couponConditionStore($request);
            return $insertCouponCondition;
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
            $showTag = $this->repository->couponConditionShow($id);
            return $showTag;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponConditionUpdateRequest $request, string $id)
    {
        try {
            $updateCouponCondition = $this->repository->couponConditionUpdate($request, $id);
            return $updateCouponCondition;
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
            $deleteCouponCondition = $this->repository->couponConditionDelete($id);
            return $deleteCouponCondition;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
