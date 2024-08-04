<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\OrderStatusInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStatusStoreRequest;
use App\Http\Requests\OrderStatusUpdateRequest;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    private OrderStatusInterface $repository;

    public function __construct(OrderStatusInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $orderStatus = $this->repository->orderStatus();
            return $orderStatus;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStatusStoreRequest $request)
    {
        try {
            $insertOrderStatus = $this->repository->orderStatusStore($request);
            return $insertOrderStatus;
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
            $showOrderStatus = $this->repository->orderStatusShow($id);
            return $showOrderStatus;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderStatusUpdateRequest $request, string $id)
    {
        try {
            $updateOrderStatus = $this->repository->orderStatusUpdate($request, $id);
            return $updateOrderStatus;
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
            $deleteOrderStatus = $this->repository->orderStatusDelete($id);
            return $deleteOrderStatus;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
