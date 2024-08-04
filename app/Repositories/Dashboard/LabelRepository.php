<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\LabelInterface;
use App\Helpers\SendingResponse;
use App\Models\label;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LabelRepository implements LabelInterface
{
    public function label()
    {
        $labels = Label::all();
        return SendingResponse::response('success', 'Label Info', $labels, '', 200);
    }

    public function labelStore($request)
    {
        $label = Label::create([
            'name'                  => $request->name,
            'slug'                  => $request->slug,
            'status'                => $request->status,
            'user_id'               => $request->user()->id,
            'created_at'            => Carbon::now(),
        ]);

        return SendingResponse::response('success', 'Label Created', $label, '', 200);
    }

    public function labelUpdate($request, $id)
    {

        $label = Label::findOrFail($id);

        $label->update([
            'user_id'               => $request->user()->id,
            'name'                  => $request->name,
            'slug'                  => $request->slug,
            'status'                => $request->status,
        ]);

        return SendingResponse::response('success', 'Label Updated', $label, '', 200);
    }

    public function labelDelete($id)
    {
        $label = Label::findOrFail($id);

        $label->delete();

        return SendingResponse::response('success', 'Label Deleted', '', '', 200);
    }

    public function labelShow($id)
    {
        $label = Label::findOrFail($id);
        return $label;
    }
}
