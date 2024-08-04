<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\ProductReviewInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductReviewStatusUpdateRequest;
use App\Http\Requests\ProductReviewStoreRequest;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    private ProductReviewInterface $repository;

    public function __construct(ProductReviewInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $productReview = $this->repository->productReview();
            return $productReview;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductReviewStoreRequest $request)
    {
        try {
            $insertProductReview = $this->repository->productReviewStore($request);
            return $insertProductReview;
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
            $showProductReview = $this->repository->productReviewShow($id);
            return $showProductReview;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductReviewStoreRequest $request, string $id)
    {
        try {
            $updateProductReview = $this->repository->productReviewUpdate($request, $id);
            return $updateProductReview;
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
            $deleteProductReview = $this->repository->productReviewDelete($id);
            return $deleteProductReview;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function statusUpdate(ProductReviewStatusUpdateRequest $request)
    {
        try {
            $statusUpdateProductReview = $this->repository->productReviewStatusUpdate($request);
            return $statusUpdateProductReview;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function productReviewReplies($id)
    {
        try {
            $productReviewReply = $this->repository->productReviewReplies($id);
            return $productReviewReply;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
