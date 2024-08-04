<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\ProductRatingInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRatingStatusUpdateRequest;
use App\Http\Requests\ProductRatingStoreRequest;
use Illuminate\Http\Request;

class ProductRatingController extends Controller
{
    private ProductRatingInterface $repository;

    public function __construct(ProductRatingInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $productRating = $this->repository->productRating();
            return $productRating;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRatingStoreRequest $request)
    {
        try {
            $insertProductRating = $this->repository->productRatingStore($request);
            return $insertProductRating;
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
            $showProductRating = $this->repository->productRatingShow($id);
            return $showProductRating;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRatingStoreRequest $request, string $id)
    {
        try {
            $updateReviewReply = $this->repository->productRatingUpdate($request, $id);
            return $updateReviewReply;
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
            $deleteProductRating = $this->repository->productRatingDelete($id);
            return $deleteProductRating;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function statusUpdate(ProductRatingStatusUpdateRequest $request)
    {
        try {
            $statusUpdateProductRating = $this->repository->productRatingStatusUpdate($request);
            return $statusUpdateProductRating;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
