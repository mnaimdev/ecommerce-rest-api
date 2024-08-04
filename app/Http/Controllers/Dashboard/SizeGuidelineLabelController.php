<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\SizeGuidelineLabelInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SizeGuidelineLabelStoreRequest;
use App\Http\Requests\SizeGuidelineLabelUpdateRequest;
use Illuminate\Http\Request;

class SizeGuidelineLabelController extends Controller
{
    private SizeGuidelineLabelInterface $repository;

    public function __construct(SizeGuidelineLabelInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $sizeGuidelineLabel = $this->repository->sizeGuidelineLabel();
            return $sizeGuidelineLabel;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SizeGuidelineLabelStoreRequest $request)
    {
        try {
            $insertSizeGuidelineLabel = $this->repository->sizeGuidelineLabelStore($request);
            return $insertSizeGuidelineLabel;
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
            $showSizeGuidelineLabel = $this->repository->sizeGuidelineLabelShow($id);
            return $showSizeGuidelineLabel;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SizeGuidelineLabelStoreRequest $request, string $id)
    {
        try {
            $updateSizeGuidelineLabel = $this->repository->sizeGuidelineLabelUpdate($request, $id);
            return $updateSizeGuidelineLabel;
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
            $deleteSizeGuidelineLabel = $this->repository->sizeGuidelineLabelDelete($id);
            return $deleteSizeGuidelineLabel;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
