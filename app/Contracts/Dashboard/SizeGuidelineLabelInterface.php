<?php

namespace App\Contracts\Dashboard;

interface SizeGuidelineLabelInterface
{
    public function sizeGuidelineLabel();
    public function sizeGuidelineLabelStore($request);
    public function sizeGuidelineLabelUpdate($request, $id);
    public function sizeGuidelineLabelDelete($id);
    public function sizeGuidelineLabelShow($id);
}
