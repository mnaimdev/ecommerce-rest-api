<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\SizeGuidelineValueInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SizeGuidelineValueStoreRequest;
use App\Http\Requests\SizeGuidelineValueUpdateRequest;
use Illuminate\Http\Request;

class SizeGuidelineValueController extends Controller
{

    private SizeGuidelineValueInterface $repository;

    public function __construct(SizeGuidelineValueInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $sizeGuidelineValue = $this->repository->sizeGuidelineValue();
            return $sizeGuidelineValue;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SizeGuidelineValueStoreRequest $request)
    {
        try {
            $insertSizeGuidelineValue = $this->repository->sizeGuidelineValueStore($request);
            return $insertSizeGuidelineValue;
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
            $showSizeGuidelineValue = $this->repository->sizeGuidelineValueShow($id);
            return $showSizeGuidelineValue;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SizeGuidelineValueStoreRequest $request, string $id)
    {
        try {
            $updateSizeGuidelineValue = $this->repository->sizeGuidelineValueUpdate($request, $id);
            return $updateSizeGuidelineValue;
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
            $deleteSizeGuidelineValue = $this->repository->sizeGuidelineValueDelete($id);
            return $deleteSizeGuidelineValue;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
