<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\AttributeNameInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeNameStoreRequest;
use App\Http\Requests\AttributeNameUpdateRequest;
use Illuminate\Http\Request;

class AttributeNameController extends Controller
{
    private AttributeNameInterface $repository;

    public function __construct(AttributeNameInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $attributeName = $this->repository->attributeName();
            return $attributeName;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributeNameStoreRequest $request)
    {
        try {
            $insertAttributeName = $this->repository->attributeNameStore($request);
            return $insertAttributeName;
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
            $showAttributeName = $this->repository->attributeNameShow($id);
            return $showAttributeName;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeNameStoreRequest $request, string $id)
    {
        try {
            $updateAttributeName = $this->repository->attributeNameUpdate($request, $id);
            return $updateAttributeName;
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
            $deleteAttributeName = $this->repository->attributeNameDelete($id);
            return $deleteAttributeName;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
