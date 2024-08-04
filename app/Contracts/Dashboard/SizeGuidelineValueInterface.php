<?php

namespace App\Contracts\Dashboard;

interface SizeGuidelineValueInterface
{
    public function sizeGuidelineValue();
    public function sizeGuidelineValueStore($request);
    public function sizeGuidelineValueUpdate($request, $id);
    public function sizeGuidelineValueDelete($id);
    public function sizeGuidelineValueShow($id);
}
