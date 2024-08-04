<?php

namespace App\Contracts\Dashboard;

interface SizeGuidelineInterface
{
    public function sizeGuideline();
    public function sizeGuidelineStore($request);
    public function sizeGuidelineUpdate($request, $id);
    public function sizeGuidelineDelete($id);
    public function sizeGuidelineShow($id);
}
