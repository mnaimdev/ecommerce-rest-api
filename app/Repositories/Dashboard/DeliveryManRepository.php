<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\DeliveryManInterface;
use App\Helpers\ImageHelper;
use App\Helpers\SendingResponse;
use App\Models\DeliveryMan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DeliveryManRepository implements DeliveryManInterface
{
    public function deliveryMan()
    {
        $deliveryMan = DeliveryMan::all();
        return SendingResponse::response('success', 'Delivery Man Info', $deliveryMan, '', 200);
    }

    public function deliveryManStore($request)
    {
        $deliveryManId = DeliveryMan::insertGetId([
            'name'                          => $request->name,
            'email'                         => $request->email,
            'phone'                         => $request->phone,
            'nid_number'                    => $request->nid_number,
            'passport_number'               => $request->passport_number,
            'address'                       => $request->address,
            'status'                        => $request->status,
            'reference_id'                  => $request->reference_id,
            'reference_name'                => $request->reference_name,
            'reference_address'             => $request->reference_address,
            'reference_nid'                 => $request->reference_nid,
            'reference_phone'               => $request->reference_phone,
            'reference_passport_number'     => $request->reference_phone,
            'created_at'                    => Carbon::now(),
        ]);


        if ($request->profile_picture != '') {
            $image = ImageHelper::saveImage($request->profile_picture, '/uploads/delivery-man/');
            DeliveryMan::findOrFail($deliveryManId)->update(
                [
                    'profile_picture' => $image,
                ]
            );
        }

        if ($request->nid_image != '') {
            $nidImage = ImageHelper::saveImage($request->nid_image, '/uploads/delivery-man/nid/');
            DeliveryMan::findOrFail($deliveryManId)->update(
                [
                    'nid_image' => $nidImage,
                ]
            );
        }


        if ($request->passport_image != '') {
            $passportImage = ImageHelper::saveImage($request->passport_image, '/uploads/delivery-man/passport/');
            DeliveryMan::findOrFail($deliveryManId)->update(
                [
                    'passport_image' => $passportImage,
                ]
            );
        }

        $deliveryMan = DeliveryMan::findOrFail($deliveryManId);

        return SendingResponse::response('success', 'Delivery Man Created', $deliveryMan, '', 200);
    }

    public function deliveryManUpdate($request, $id)
    {
        $deliveryMan = DeliveryMan::findOrFail($id);

        $deliveryMan->update([
            'name'                            => $request->name,
            'email'                           => $request->email,
            'phone'                           => $request->phone,
            'nid_number'                      => $request->nid_number,
            'passport_number'                 => $request->passport_number,
            'address'                         => $request->address,
            'status'                          => $request->status,
            'reference_id'                    => $request->reference_id,
            'reference_name'                  => $request->reference_name,
            'reference_address'               => $request->reference_address,
            'reference_nid'                   => $request->reference_nid,
            'reference_phone'                 => $request->reference_phone,
            'reference_passport_number'       => $request->reference_passport_number,
        ]);

        if ($request->profile_picture != '') {
            if ($deliveryMan->profile_picture != '') {
                ImageHelper::removeImage($deliveryMan->profile_picture);
            }
            $image = ImageHelper::saveImage($request->profile_picture, '/uploads/delivery-man/');
            $deliveryMan->update(
                [
                    'profile_picture' => $image,
                ]
            );
        }

        if ($request->nid_image != '') {
            if ($deliveryMan->nid_image != '') {
                ImageHelper::removeImage($deliveryMan->nid_image);
            }
            $nidImage = ImageHelper::saveImage($request->nid_image, '/uploads/delivery-man/nid/');
            $deliveryMan->update(
                [
                    'nid_image' => $nidImage,
                ]
            );
        }

        if ($request->passport_image != '') {
            if ($deliveryMan->passport_image != '') {
                ImageHelper::removeImage($deliveryMan->passport_image);
            }
            $passportImage = ImageHelper::saveImage($request->passport_image, '/uploads/delivery-man/passport/');
            $deliveryMan->update(
                [
                    'passport_image' => $passportImage,
                ]
            );
        }

        return SendingResponse::response('success', 'Delivery Man Updated', $deliveryMan, '', 200);
    }

    public function deliveryManDelete($id)
    {
        $deliveryMan = DeliveryMan::findOrFail($id);

        if ($deliveryMan->profile_picture != '') {
            ImageHelper::removeImage($deliveryMan->profile_picture);
        }

        if ($deliveryMan->nid_image != '') {
            ImageHelper::removeImage($deliveryMan->nid_image);
        }

        if ($deliveryMan->passport_image != '') {
            ImageHelper::removeImage($deliveryMan->passport_image);
        }

        $deliveryMan->delete();

        return SendingResponse::response('success', 'Delivery Man Deleted', '', '', 200);
    }

    public function deliveryManShow($id)
    {
        $deliveryMan = DeliveryMan::findOrFail($id);
        return SendingResponse::response('success', 'Delivery Man', $deliveryMan, '', 200);
    }
}
