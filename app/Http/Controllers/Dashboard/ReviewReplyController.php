<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\ReviewReplyInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewReplyStatusUpdateRequest;
use App\Http\Requests\ReviewReplyStoreRequest;
use Illuminate\Http\Request;

class ReviewReplyController extends Controller
{
    private ReviewReplyInterface $repository;

    public function __construct(ReviewReplyInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $reviewReply = $this->repository->reviewReply();
            return $reviewReply;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewReplyStoreRequest $request)
    {
        try {
            $insertReviewReply = $this->repository->reviewReplyStore($request);
            return $insertReviewReply;
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
            $showReviewReply = $this->repository->reviewReplyShow($id);
            return $showReviewReply;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReviewReplyStoreRequest $request, string $id)
    {
        try {
            $updateReviewReply = $this->repository->reviewReplyUpdate($request, $id);
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
            $deleteReviewReply = $this->repository->reviewReplyDelete($id);
            return $deleteReviewReply;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function statusUpdate(ReviewReplyStatusUpdateRequest $request)
    {
        try {
            $statusUpdateReviewReply = $this->repository->reviewReplyStatusUpdate($request);
            return $statusUpdateReviewReply;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
