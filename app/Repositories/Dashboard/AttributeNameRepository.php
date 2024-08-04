<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\AttributeNameInterface;
use App\Helpers\SendingResponse;
use App\Models\AttributeName;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttributeNameRepository implements AttributeNameInterface
{
    public function attributeName()
    {
        $attributeName = AttributeName::all();
        return SendingResponse::response('success', 'Attribute Name Info', $attributeName, '', 200);
    }

    public function attributeNameStore($request)
    {
        $attributeName = AttributeName::create([
            'name'                  => $request->name,
            'status'                => $request->status,
            'user_id'               => $request->user()->id,
            'created_at'            => Carbon::now(),
        ]);

        return SendingResponse::response('success', 'Attribute Name Created', $attributeName, '', 200);
    }

    public function attributeNameUpdate($request, $id)
    {

        $attributeName = AttributeName::findOrFail($id);

        $attributeName->update([
            'user_id'               => $request->user()->id,
            'name'                  => $request->name,
            'status'                => $request->status,
        ]);

        return SendingResponse::response('success', 'Attribute Name Updated', $attributeName, '', 200);
    }

    public function attributeNameDelete($id)
    {
        $attributeName = AttributeName::findOrFail($id);

        $attributeName->delete();

        return SendingResponse::response('success', 'Attribute Name Deleted', '', '', 200);
    }

    public function attributeNameShow($id)
    {
        $attributeName = AttributeName::findOrFail($id);

        return SendingResponse::response('success', 'Attribute Name', $attributeName, '', 200);
    }
}
