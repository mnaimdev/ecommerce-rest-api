<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\CourierInterface;
use App\Helpers\SendingResponse;
use App\Models\Courier;
use Carbon\Carbon;

class CourierRepository implements CourierInterface
{
    public function courier()
    {
        $courier = Courier::all();
        return SendingResponse::response('success', 'Courier Info', $courier, '', 200);
    }

    public function courierStore($request)
    {
        $courier = Courier::create([
            'name'                              => $request->name,
            'status'                            => $request->status,
            'created_at'                        => Carbon::now(),
        ]);

        return SendingResponse::response('success', 'Courier Created', $courier, '', 200);
    }

    public function courierUpdate($request, $id)
    {
        $courier = Courier::findOrFail($id);

        $courier->update([
            'name'                              => $request->name,
            'status'                            => $request->status,
        ]);

        return SendingResponse::response('success', 'Courier Updated', $courier, '', 200);
    }

    public function courierDelete($id)
    {
        $courier = Courier::findOrFail($id);

        $courier->delete();

        return SendingResponse::response('success', 'Courier Deleted', '', '', 200);
    }

    public function courierShow($id)
    {
        $courier = Courier::findOrFail($id);

        return SendingResponse::response('success', 'Courier', $courier, '', 200);
    }
}
