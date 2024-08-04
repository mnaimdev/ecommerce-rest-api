<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\SocialShopInterface;
use App\Helpers\ImageHelper;
use App\Helpers\SendingResponse;
use App\Models\SocialShop;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SocialShopRepository implements SocialShopInterface
{
    public function socialShop()
    {
        $socialShop = SocialShop::all();
        return SendingResponse::response('success', 'Social Shop Info', $socialShop, '', 200);
    }

    public function socialShopStore($request)
    {
        $socialShopId = SocialShop::insertGetId([
            'page_name'        => $request->page_name,
            'page_url'         => $request->page_url,
            'status'           => $request->status,
            'user_id'          => $request->user()->id,
            'created_at'       => Carbon::now(),
        ]);

        if ($request->page_logo != '') {
            $image = ImageHelper::saveImage($request->page_logo, '/uploads/social-shop/');
            SocialShop::findOrFail($socialShopId)->update(
                [
                    'page_logo' => $image,
                ]
            );
        }

        $socialShop = SocialShop::findOrFail($socialShopId);

        return SendingResponse::response('success', 'Social Shop Created', $socialShop, '', 200);
    }

    public function socialShopUpdate($request, $id)
    {
        $socialShop = SocialShop::findOrFail($id);

        $socialShop->update([
            'page_name'        => $request->page_name,
            'page_url'         => $request->page_url,
            'status'           => $request->status,
            'user_id'          => $request->user()->id,
        ]);

        if ($request->page_logo != '') {
            if ($socialShop->page_logo != '') {
                ImageHelper::removeImage($socialShop->page_logo);
            }
            $image = ImageHelper::saveImage($request->page_logo, '/uploads/social-shop/');

            $socialShop->update([
                'page_logo' => $image,
            ]);
        }


        return SendingResponse::response('success', 'Social Shop Updated', $socialShop, '', 200);
    }

    public function socialShopDelete($id)
    {
        $socialShop = SocialShop::findOrFail($id);

        if ($socialShop->page_logo != '') {
            ImageHelper::removeImage($socialShop->page_logo);
        }

        $socialShop->delete();

        return SendingResponse::response('success', 'Social Shop Deleted', '', '', 200);
    }

    public function socialShopShow($id)
    {
        $socialShop = SocialShop::findOrFail($id);
        return SendingResponse::response('success', 'Social Shop', $socialShop, '', 200);
    }
}
