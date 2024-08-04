<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\ShippingAddressInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingAddressStoreRequest;
use Illuminate\Http\Request;

class ShippingAddressController extends Controller
{
    private ShippingAddressInterface $repository;

    public function __construct(ShippingAddressInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $shippingAddress = $this->repository->shippingAddress();
            return $shippingAddress;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShippingAddressStoreRequest $request)
    {
        try {
            $insertShippingAddress = $this->repository->shippingAddressStore($request);
            return $insertShippingAddress;
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
            $showShippingAddress = $this->repository->shippingAddressShow($id);
            return $showShippingAddress;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShippingAddressStoreRequest $request, string $id)
    {
        try {
            $updateShippingAddress = $this->repository->shippingAddressUpdate($request, $id);
            return $updateShippingAddress;
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
            $deleteShippingAddress = $this->repository->shippingAddressDelete($id);
            return $deleteShippingAddress;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
