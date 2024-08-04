<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\LabelInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LabelStoreRequest;
use App\Http\Requests\LabelUpdateRequest;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    private LabelInterface $repository;

    public function __construct(LabelInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $label = $this->repository->label();
            return $label;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LabelStoreRequest $request)
    {
        try {
            $insertlabel = $this->repository->labelStore($request);
            return $insertlabel;
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
            $showLabel = $this->repository->labelShow($id);
            return $showLabel;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LabelUpdateRequest $request, string $id)
    {
        try {
            $updatelabel = $this->repository->labelUpdate($request, $id);
            return $updatelabel;
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
            $deletelabel = $this->repository->labelDelete($id);
            return $deletelabel;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
