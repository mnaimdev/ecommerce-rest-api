<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\PosBranchInterface;
use App\Helpers\SendingResponse;
use App\Models\PosBranch;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PosBranchRepository implements PosBranchInterface
{
    public function posBranch()
    {
        $posBranch = PosBranch::all();
        return SendingResponse::response('success', 'Pos Branch Info', $posBranch, '', 200);
    }

    public function posBranchStore($request)
    {
        $posBranch = PosBranch::create([
            'branch_name'           => $request->branch_name,
            'branch_location'       => $request->branch_location,
            'latitude'              => $request->latitude,
            'longitude'             => $request->longitude,
            'status'                => $request->status,
            'created_at'            => Carbon::now(),
        ]);

        return SendingResponse::response('success', 'Pos Branch Created', $posBranch, '', 200);
    }

    public function posBranchUpdate($request, $id)
    {

        $posBranch = PosBranch::findOrFail($id);

        $posBranch->update([
            'branch_name'           => $request->branch_name,
            'branch_location'       => $request->branch_location,
            'latitude'              => $request->latitude,
            'longitude'             => $request->longitude,
            'status'                => $request->status,
        ]);

        return SendingResponse::response('success', 'Pos Branch Updated', $posBranch, '', 200);
    }

    public function posBranchDelete($id)
    {
        $posBranch = PosBranch::findOrFail($id);

        $posBranch->delete();

        return SendingResponse::response('success', 'Pos Branch Deleted', '', '', 200);
    }

    public function posBranchShow($id)
    {
        $posBranch = PosBranch::findOrFail($id);

        return SendingResponse::response('success', 'Pos Branch', $posBranch, '', 200);
    }
}
