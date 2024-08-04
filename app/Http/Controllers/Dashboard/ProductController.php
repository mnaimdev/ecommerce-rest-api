<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\ProductInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\FrequentlyBuyProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductInterface $repository;

    public function __construct(ProductInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $product = $this->repository->product();
            return $product;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        try {
            $insertProduct = $this->repository->productStore($request);
            return $insertProduct;
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
            $showProduct = $this->repository->productShow($id);
            return $showProduct;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        try {
            $updateProduct = $this->repository->productUpdate($request, $id);
            return $updateProduct;
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
            $deleteProduct = $this->repository->productDelete($id);
            return $deleteProduct;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function searchProduct(Request $request)
    {
        try {
            $searchProduct = $this->repository->searchProduct($request);
            return $searchProduct;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
