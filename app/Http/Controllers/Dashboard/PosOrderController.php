<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\PosOrderInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\PosOrderStoreRequest;
use Illuminate\Http\Request;

class PosOrderController extends Controller
{
    private PosOrderInterface $repository;

    public function __construct(PosOrderInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $posOrder = $this->repository->posOrder();
            return $posOrder;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PosOrderStoreRequest $request)
    {
        try {
            $insertPosOrder = $this->repository->posOrderStore($request);
            return $insertPosOrder;
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
            $showPosOrder = $this->repository->posOrderShow($id);
            return $showPosOrder;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PosOrderStoreRequest $request, string $id)
    {
        try {
            $updatePosOrder = $this->repository->posOrderUpdate($request, $id);
            return $updatePosOrder;
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
            $deletePosOrder = $this->repository->posOrderDelete($id);
            return $deletePosOrder;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
