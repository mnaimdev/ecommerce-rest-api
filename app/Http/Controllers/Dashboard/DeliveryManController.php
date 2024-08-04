<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\DeliveryManInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryManStoreRequest;
use App\Http\Requests\DeliveryManUpdateRequest;
use Illuminate\Http\Request;

class DeliveryManController extends Controller
{
    private DeliveryManInterface $repository;

    public function __construct(DeliveryManInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $deliveryMan = $this->repository->deliveryMan();
            return $deliveryMan;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeliveryManStoreRequest $request)
    {
        try {
            $insertDeliveryMan = $this->repository->deliveryManStore($request);
            return $insertDeliveryMan;
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
            $showDeliveryMan = $this->repository->deliveryManShow($id);
            return $showDeliveryMan;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DeliveryManUpdateRequest $request, string $id)
    {
        try {
            $updateDeliveryMan = $this->repository->deliveryManUpdate($request, $id);
            return $updateDeliveryMan;
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
            $deleteDeliveryMan = $this->repository->deliveryManDelete($id);
            return $deleteDeliveryMan;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
