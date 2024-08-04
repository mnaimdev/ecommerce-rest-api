<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\SizeGuidelineValueInterface;
use App\Helpers\SendingResponse;
use App\Models\SizeGuidelineLabel;
use App\Models\SizeGuidelineValue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SizeGuidelineValueRepository implements SizeGuidelineValueInterface
{
    public function sizeGuidelineValue()
    {
        $sizeGuidelineValue = SizeGuidelineValue::with(['sizeGuideline', 'sizeGuidelineLabel'])->get();
        return SendingResponse::response('success', 'Size Guideline Value Info', $sizeGuidelineValue, '', 200);
    }

    public function sizeGuidelineValueStore($request)
    {
        $sizeGuidelineValue = SizeGuidelineValue::create([
            'size_guideline_id'             => $request->size_guideline_id,
            'size_guideline_label_id'       => $request->size_guideline_label_id,
            'name'                          => $request->name,
            'created_at'                    => Carbon::now(),
        ]);

        return SendingResponse::response('success', 'Size Guideline Value Created', $sizeGuidelineValue, '', 200);
    }

    public function sizeGuidelineValueUpdate($request, $id)
    {
        $sizeGuidelineValue = SizeGuidelineValue::findOrFail($id);

        $sizeGuidelineValue->update([
            'size_guideline_id'             => $request->size_guideline_id,
            'size_guideline_label_id'       => $request->size_guideline_label_id,
            'name'                          => $request->name,
        ]);

        return SendingResponse::response('success', 'Size Guideline Value Updated', $sizeGuidelineValue, '', 200);
    }

    public function sizeGuidelineValueDelete($id)
    {
        $sizeGuidelineValue = SizeGuidelineValue::findOrFail($id);

        $sizeGuidelineValue->delete();

        return SendingResponse::response('success', 'Size Guideline Value Deleted', '', '', 200);
    }

    public function sizeGuidelineValueShow($id)
    {
        $sizeGuidelineValue = SizeGuidelineValue::findOrFail($id);

        return SendingResponse::response('success', 'Size Guideline Value', $sizeGuidelineValue, '', 200);
    }
}
