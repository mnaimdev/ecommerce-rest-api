<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\OrderStatusInterface;
use App\Enums\OrderStatusEnum;
use App\Helpers\SendingResponse;
use App\Models\label;
use App\Models\OrderStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderStatusRepository implements OrderStatusInterface
{
    public function orderStatus()
    {
        $orderStatus = OrderStatus::all();
        return SendingResponse::response('success', 'Order Status Info', $orderStatus, '', 200);
    }

    public function orderStatusStore($request)
    {

        // working with name
        if ($request->name == OrderStatusEnum::PENDING->value) {
            $name = OrderStatusEnum::PENDING->value;
        } else if ($request->name == OrderStatusEnum::WAITING->value) {
            $name = OrderStatusEnum::WAITING->value;
        } else if ($request->name == OrderStatusEnum::PROCESSING->value) {
            $name = OrderStatusEnum::PROCESSING->value;
        } else if ($request->name == OrderStatusEnum::ONTHEWAY->value) {
            $name = OrderStatusEnum::ONTHEWAY->value;
        } else if ($request->name == OrderStatusEnum::DELIVERED->value) {
            $name = OrderStatusEnum::DELIVERED->value;
        } else if ($request->name == OrderStatusEnum::COMPLETED->value) {
            $name = OrderStatusEnum::COMPLETED->value;
        } else if ($request->name == OrderStatusEnum::CANCELLED->value) {
            $name = OrderStatusEnum::CANCELLED->value;
        }

        $orderStatus = OrderStatus::create([
            'name'                  => $name,
            'slug'                  => $request->slug,
            'status'                => $request->status,
            'created_at'            => Carbon::now(),
        ]);

        return SendingResponse::response('success', 'Order Status Created', $orderStatus, '', 200);
    }

    public function orderStatusUpdate($request, $id)
    {

        $orderStatus = OrderStatus::findOrFail($id);

        // working with name
        if ($request->name == OrderStatusEnum::PENDING->value) {
            $name = OrderStatusEnum::PENDING->value;
        } else if ($request->name == OrderStatusEnum::WAITING->value) {
            $name = OrderStatusEnum::WAITING->value;
        } else if ($request->name == OrderStatusEnum::PROCESSING->value) {
            $name = OrderStatusEnum::PROCESSING->value;
        } else if ($request->name == OrderStatusEnum::ONTHEWAY->value) {
            $name = OrderStatusEnum::ONTHEWAY->value;
        } else if ($request->name == OrderStatusEnum::DELIVERED->value) {
            $name = OrderStatusEnum::DELIVERED->value;
        } else if ($request->name == OrderStatusEnum::COMPLETED->value) {
            $name = OrderStatusEnum::COMPLETED->value;
        } else if ($request->name == OrderStatusEnum::CANCELLED->value) {
            $name = OrderStatusEnum::CANCELLED->value;
        }

        $orderStatus->update([
            'name'                  => $name,
            'slug'                  => $request->slug,
            'status'                => $request->status,
        ]);

        return SendingResponse::response('success', 'Order Status Updated', $orderStatus, '', 200);
    }

    public function orderStatusDelete($id)
    {
        $orderStatus = OrderStatus::findOrFail($id);

        $orderStatus->delete();

        return SendingResponse::response('success', 'Order Status Deleted', '', '', 200);
    }

    public function orderStatusShow($id)
    {
        $orderStatus = OrderStatus::findOrFail($id);
        return $orderStatus;
    }
}
