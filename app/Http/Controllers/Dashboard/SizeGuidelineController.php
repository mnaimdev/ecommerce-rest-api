<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\SizeGuidelineInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SizeGuidelineStoreRequest;
use App\Http\Requests\SizeGuidelineUpdateRequest;
use Illuminate\Http\Request;

class SizeGuidelineController extends Controller
{

    private SizeGuidelineInterface $repository;

    public function __construct(SizeGuidelineInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {
            $sizeGuideline = $this->repository->sizeGuideline();
            return $sizeGuideline;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SizeGuidelineStoreRequest $request)
    {
        try {
            $insertSizeGuideline = $this->repository->sizeGuidelineStore($request);
            return $insertSizeGuideline;
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
            $showSizeGuideline = $this->repository->sizeGuidelineShow($id);
            return $showSizeGuideline;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SizeGuidelineStoreRequest $request, string $id)
    {
        try {
            $updateSizeGuideline = $this->repository->sizeGuidelineUpdate($request, $id);
            return $updateSizeGuideline;
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
            $deleteSizeGuideline = $this->repository->sizeGuidelineDelete($id);
            return $deleteSizeGuideline;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
