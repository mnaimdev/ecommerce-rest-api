<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\CourierBranchInterface;
use App\Helpers\SendingResponse;
use App\Models\Courier;
use App\Models\CourierBranch;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourierBranchRepository implements CourierBranchInterface
{
    public function courierBranch()
    {
        $courierBranch = CourierBranch::all();
        return SendingResponse::response('success', 'Courier Branch Info', $courierBranch, '', 200);
    }

    public function courierBranchStore($request)
    {
        $courierBranch = CourierBranch::create([
            'courier_id'                        => $request->courier_id,
            'branch_name'                       => $request->branch_name,
            'branch_location'                   => $request->branch_location,
            'branch_latitude'                   => $request->branch_latitude,
            'branch_longitude'                  => $request->branch_longitude,
            'merchant_account_no'               => $request->merchant_account_no,
            'contact_person_one_name'           => $request->contact_person_one_name,
            'contact_person_one_phone'          => $request->contact_person_one_phone,
            'contact_person_two_name'           => $request->contact_person_two_name,
            'contact_person_two_phone'          => $request->contact_person_two_phone,
            'status'                            => $request->status,
            'created_at'                        => Carbon::now(),
        ]);

        return SendingResponse::response('success', 'Courier Branch Created', $courierBranch, '', 200);
    }

    public function courierBranchUpdate($request, $id)
    {
        $courierBranch = CourierBranch::findOrFail($id);

        $courierBranch->update([
            'courier_id'                        => $request->courier_id,
            'branch_name'                       => $request->branch_name,
            'branch_location'                   => $request->branch_location,
            'branch_latitude'                   => $request->branch_latitude,
            'branch_longitude'                  => $request->branch_longitude,
            'merchant_account_no'               => $request->merchant_account_no,
            'contact_person_one_name'           => $request->contact_person_one_name,
            'contact_person_one_phone'          => $request->contact_person_one_phone,
            'contact_person_two_name'           => $request->contact_person_two_name,
            'contact_person_two_phone'          => $request->contact_person_two_phone,
            'status'                            => $request->status,
        ]);

        return SendingResponse::response('success', 'Courier Branch Updated', $courierBranch, '', 200);
    }

    public function courierBranchDelete($id)
    {
        $courierBranch = CourierBranch::findOrFail($id);

        $courierBranch->delete();

        return SendingResponse::response('success', 'Courier Branch Deleted', '', '', 200);
    }

    public function courierBranchShow($id)
    {
        $courierBranch = CourierBranch::findOrFail($id);

        return SendingResponse::response('success', 'Courier Branch', $courierBranch, '', 200);
    }
}
