<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\CourierInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourierStoreRequest;
use App\Http\Requests\CourierUpdateRequest;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    private CourierInterface $repository;

    public function __construct(CourierInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $courier = $this->repository->courier();
            return $courier;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourierStoreRequest $request)
    {
        try {
            $insertCourier = $this->repository->courierStore($request);
            return $insertCourier;
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
            $showCourier = $this->repository->courierShow($id);
            return $showCourier;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourierUpdateRequest $request, string $id)
    {
        try {
            $updateCourier = $this->repository->courierUpdate($request, $id);
            return $updateCourier;
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
            $deleteCourier = $this->repository->courierDelete($id);
            return $deleteCourier;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
