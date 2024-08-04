<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\SizeGuidelineInterface;
use App\Helpers\SendingResponse;
use App\Models\SizeGuideline;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SizeGuidelineRepository implements SizeGuidelineInterface
{
    public function sizeGuideline()
    {
        $sizeGuideline = SizeGuideline::with('product')->get();
        return SendingResponse::response('success', 'Size Guideline Info', $sizeGuideline, '', 200);
    }

    public function sizeGuidelineStore($request)
    {
        $sizeGuideline = SizeGuideline::create([
            'name'             => $request->name,
            'status'           => $request->status,
            'created_at'       => Carbon::now(),
        ]);

        return SendingResponse::response('success', 'Size Guideline Created', $sizeGuideline, '', 200);
    }

    public function sizeGuidelineUpdate($request, $id)
    {
        $sizeGuideline = SizeGuideline::findOrFail($id);

        $sizeGuideline->update([
            'name'             => $request->name,
            'status'           => $request->status,
        ]);

        return SendingResponse::response('success', 'Size Guideline Updated', $sizeGuideline, '', 200);
    }

    public function sizeGuidelineDelete($id)
    {
        $sizeGuideline = SizeGuideline::findOrFail($id);

        $sizeGuideline->delete();

        return SendingResponse::response('success', 'Size Guideline Deleted', '', '', 200);
    }

    public function sizeGuidelineShow($id)
    {
        $sizeGuideline = SizeGuideline::findOrFail($id);

        return SendingResponse::response('success', 'Size Guideline', $sizeGuideline, '', 200);
    }
}
