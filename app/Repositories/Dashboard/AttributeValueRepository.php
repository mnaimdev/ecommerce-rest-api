<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\AttributeValueInterface;
use App\Helpers\SendingResponse;
use App\Models\AttributeName;
use App\Models\AttributeValue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttributeValueRepository implements AttributeValueInterface
{
    public function attributeValue()
    {
        $attributeValue = AttributeValue::all();
        return SendingResponse::response('success', 'Attribute Value Info', $attributeValue, '', 200);
    }

    public function attributeValueStore($request)
    {
        $attributeValue = AttributeValue::create([
            'name'                  => $request->name,
            'status'                => $request->status,
            'user_id'               => $request->user()->id,
            'attribute_name_id'     => $request->attribute_name_id,
            'created_at'            => Carbon::now(),
        ]);

        return SendingResponse::response('success', 'Attribute Value Created', $attributeValue, '', 200);
    }

    public function attributeValueUpdate($request, $id)
    {

        $attributeValue = AttributeValue::findOrFail($id);

        $attributeValue->update([
            'name'                  => $request->name,
            'status'                => $request->status,
            'user_id'               => $request->user()->id,
            'attribute_name_id'     => $request->attribute_name_id,
        ]);

        return SendingResponse::response('success', 'Attribute Value Updated', $attributeValue, '', 200);
    }

    public function attributeValueDelete($id)
    {
        $attributeValue = AttributeValue::findOrFail($id);

        $attributeValue->delete();

        return SendingResponse::response('success', 'Attribute Value Deleted', '', '', 200);
    }

    public function attributeValueShow($id)
    {
        $attributeValue = AttributeValue::findOrFail($id);

        return SendingResponse::response('success', 'Attribute Value', $attributeValue, '', 200);
    }
}
