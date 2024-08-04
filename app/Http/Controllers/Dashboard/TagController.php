<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\TagInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private TagInterface $repository;

    public function __construct(TagInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tag = $this->repository->tag();
            return $tag;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagStoreRequest $request)
    {
        try {
            $insertTag = $this->repository->tagStore($request);
            return $insertTag;
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
            $showTag = $this->repository->tagShow($id);
            return $showTag;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagUpdateRequest $request, string $id)
    {
        try {
            $updateTag = $this->repository->tagUpdate($request, $id);
            return $updateTag;
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
            $deleteTag = $this->repository->tagDelete($id);
            return $deleteTag;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
