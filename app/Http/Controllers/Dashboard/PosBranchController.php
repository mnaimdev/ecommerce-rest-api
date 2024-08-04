<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\PosBranchInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PosBranchStoreRequest;
use App\Http\Requests\PosBranchUpdateRequest;
use Illuminate\Http\Request;

class PosBranchController extends Controller
{
    private PosBranchInterface $repository;

    public function __construct(PosBranchInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $posBranch = $this->repository->posBranch();
            return $posBranch;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PosBranchStoreRequest $request)
    {
        try {
            $insertPosBranch = $this->repository->posBranchStore($request);
            return $insertPosBranch;
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
            $showPosBranch = $this->repository->posBranchShow($id);
            return $showPosBranch;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PosBranchUpdateRequest $request, string $id)
    {
        try {
            $updatePosBranch = $this->repository->posBranchUpdate($request, $id);
            return $updatePosBranch;
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
            $deletePosBranch = $this->repository->posBranchDelete($id);
            return $deletePosBranch;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
