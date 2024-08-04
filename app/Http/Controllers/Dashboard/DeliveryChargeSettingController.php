<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\DeliveryChargeSettingInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryChargeSettingStoreRequest;
use Illuminate\Http\Request;

class DeliveryChargeSettingController extends Controller
{
    private DeliveryChargeSettingInterface $repository;

    public function __construct(DeliveryChargeSettingInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $deliveryChargeSetting = $this->repository->deliveryChargeSetting();
            return $deliveryChargeSetting;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeliveryChargeSettingStoreRequest $request)
    {
        try {
            $insertDeliveryChargeSetting = $this->repository->deliveryChargeSettingStore($request);
            return $insertDeliveryChargeSetting;
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
            $showDeliveryChargeSetting = $this->repository->deliveryChargeSettingShow($id);
            return $showDeliveryChargeSetting;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DeliveryChargeSettingStoreRequest $request, string $id)
    {
        try {
            $updateDeliveryChargeSetting = $this->repository->deliveryChargeSettingUpdate($request, $id);
            return $updateDeliveryChargeSetting;
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
            $deleteDeliveryChargeSetting = $this->repository->deliveryChargeSettingDelete($id);
            return $deleteDeliveryChargeSetting;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
