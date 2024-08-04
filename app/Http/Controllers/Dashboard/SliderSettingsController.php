<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Dashboard\SliderSettingsInterface;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderSettingStoreRequest;
use Illuminate\Http\Request;

class SliderSettingsController extends Controller
{
    private SliderSettingsInterface $repository;

    public function __construct(SliderSettingsInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $sliderSettings = $this->repository->sliderSettings();
            return $sliderSettings;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(SliderSettingStoreRequest $request)
    {
        try {
            $insertSliderSettings = $this->repository->sliderSettingsUpdate($request);
            return $insertSliderSettings;
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
