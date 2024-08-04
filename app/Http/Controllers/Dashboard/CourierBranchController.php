<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\CourierBranchInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourierBranchStoreRequest;
use App\Http\Requests\CourierBranchUpdateRequest;
use Illuminate\Http\Request;

class CourierBranchController extends Controller
{
    private CourierBranchInterface $repository;

    public function __construct(CourierBranchInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $courierBranch = $this->repository->courierBranch();
            return $courierBranch;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourierBranchStoreRequest $request)
    {
        try {
            $insertCourierBranch = $this->repository->courierBranchStore($request);
            return $insertCourierBranch;
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
            $showCourierBranch = $this->repository->courierBranchShow($id);
            return $showCourierBranch;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourierBranchUpdateRequest $request, string $id)
    {
        try {
            $updateCourierBranch = $this->repository->courierBranchUpdate($request, $id);
            return $updateCourierBranch;
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
            $deleteCourierBranch = $this->repository->courierBranchDelete($id);
            return $deleteCourierBranch;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
