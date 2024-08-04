<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\FlashSaleInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlashSaleStoreRequest;
use App\Http\Requests\FlashSaleUpdateRequest;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{

    private FlashSaleInterface $repository;

    public function __construct(FlashSaleInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $flashSale = $this->repository->flashSale();
            return $flashSale;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FlashSaleStoreRequest $request)
    {
        try {
            $insertFlashSale = $this->repository->flashSaleStore($request);
            return $insertFlashSale;
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
            $showFlashSale = $this->repository->flashSaleShow($id);
            return $showFlashSale;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FlashSaleUpdateRequest $request, string $id)
    {
        try {
            $updateFlashSale = $this->repository->flashSaleUpdate($request, $id);
            return $updateFlashSale;
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
            $deleteFlashSale = $this->repository->flashSaleDelete($id);
            return $deleteFlashSale;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
