<?php

namespace App\Contracts\Dashboard;

interface SliderImageInterface
{
    public function sliderImage();
    public function sliderImageStore($request);
    public function sliderImageUpdate($request, $id);
    public function sliderImageDelete($id);
    public function sliderImageShow($id);
}
