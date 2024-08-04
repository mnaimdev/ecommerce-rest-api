<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\FaqInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqStoreRequest;
use App\Http\Requests\FaqUpdateRequest;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    private FaqInterface $repository;

    public function __construct(FaqInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $faq = $this->repository->faq();
            return $faq;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqStoreRequest $request)
    {
        try {
            $insertFaq = $this->repository->faqStore($request);
            return $insertFaq;
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
            $showFaq = $this->repository->faqShow($id);
            return $showFaq;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqStoreRequest $request, string $id)
    {
        try {
            $updateFaq = $this->repository->faqUpdate($request, $id);
            return $updateFaq;
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
            $deleteFaq = $this->repository->faqDelete($id);
            return $deleteFaq;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
