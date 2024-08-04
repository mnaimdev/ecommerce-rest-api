<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\PosCustomerInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PosCustomerController extends Controller
{
    private PosCustomerInterface $repository;

    public function __construct(PosCustomerInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $posCustomer = $this->repository->posCustomer();
            return $posCustomer;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $insertPosCustomer = $this->repository->posCustomerStore($request);
            return $insertPosCustomer;
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
            $showPosCustomer = $this->repository->posCustomerShow($id);
            return $showPosCustomer;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $updatePosCustomer = $this->repository->posCustomerUpdate($request, $id);
            return $updatePosCustomer;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     try {
    //         $deletePosCustomer = $this->repository->posCustomerDelete($id);
    //         return $deletePosCustomer;
    //     } catch (\Exception $e) {
    //         return SendingResponse::handleException('error', $e->getMessage());
    //     }
    // }

    public function searchCustomer(Request $request)
    {
        try {
            $searchCustomer = $this->repository->searchCustomer($request);
            return $searchCustomer;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
