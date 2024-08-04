<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\AttributeValueInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeValueStoreRequest;
use App\Http\Requests\AttributeValueUpdateRequest;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    private AttributeValueInterface $repository;

    public function __construct(AttributeValueInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $attributeValue = $this->repository->attributeValue();
            return $attributeValue;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributeValueStoreRequest $request)
    {
        try {
            $insertAttributeValue = $this->repository->attributeValueStore($request);
            return $insertAttributeValue;
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
            $showAttributeValue = $this->repository->attributeValueShow($id);
            return $showAttributeValue;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeValueStoreRequest $request, string $id)
    {
        try {
            $updateAttributeValue = $this->repository->attributeValueUpdate($request, $id);
            return $updateAttributeValue;
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
            $deleteAttributeValue = $this->repository->attributeValueDelete($id);
            return $deleteAttributeValue;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
