<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\SliderImageInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderImageStoreRequest;
use App\Http\Requests\SliderImageUpdateRequest;
use Illuminate\Http\Request;

class SliderImageController extends Controller
{
    private SliderImageInterface $repository;

    public function __construct(SliderImageInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $sliderImage = $this->repository->sliderImage();
            return $sliderImage;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderImageStoreRequest $request)
    {
        try {
            $insertSliderImage = $this->repository->sliderImageStore($request);
            return $insertSliderImage;
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
            $showSliderImage = $this->repository->sliderImageShow($id);
            return $showSliderImage;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderImageUpdateRequest $request, string $id)
    {
        try {
            $updateSliderImage = $this->repository->sliderImageUpdate($request, $id);
            return $updateSliderImage;
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
            $deleteSliderImage = $this->repository->sliderImageDelete($id);
            return $deleteSliderImage;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
