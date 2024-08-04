<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\SizeGuidelineLabelInterface;
use App\Helpers\SendingResponse;
use App\Models\SizeGuidelineLabel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SizeGuidelineLabelRepository implements SizeGuidelineLabelInterface
{
    public function sizeGuidelineLabel()
    {
        $sizeGuidelineLabel = SizeGuidelineLabel::all();
        return SendingResponse::response('success', 'Size Guideline Label Info', $sizeGuidelineLabel, '', 200);
    }

    public function sizeGuidelineLabelStore($request)
    {
        $sizeGuidelineLabel = SizeGuidelineLabel::create([
            'size_guideline_id'       => $request->size_guideline_id,
            'name'                    => $request->name,
            'created_at'              => Carbon::now(),
        ]);

        return SendingResponse::response('success', 'Size Guideline Label Created', $sizeGuidelineLabel, '', 200);
    }

    public function sizeGuidelineLabelUpdate($request, $id)
    {
        $sizeGuidelineLabel = SizeGuidelineLabel::findOrFail($id);

        $sizeGuidelineLabel->update([
            'size_guideline_id'       => $request->size_guideline_id,
            'name'                    => $request->name,
        ]);

        return SendingResponse::response('success', 'Size Guideline Label Updated', $sizeGuidelineLabel, '', 200);
    }

    public function sizeGuidelineLabelDelete($id)
    {
        $sizeGuidelineLabel = SizeGuidelineLabel::findOrFail($id);

        $sizeGuidelineLabel->delete();

        return SendingResponse::response('success', 'Size Guideline Label Deleted', '', '', 200);
    }

    public function sizeGuidelineLabelShow($id)
    {
        $sizeGuidelineLabel = SizeGuidelineLabel::findOrFail($id);

        return SendingResponse::response('success', 'Size Guideline Label', $sizeGuidelineLabel, '', 200);
    }
}
