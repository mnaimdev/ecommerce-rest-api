<?php

namespace App\Repositories\Dashboard;


use App\Contracts\Dashboard\CustomerInterface;
use App\Enums\CouponCustomerEnum;
use App\Enums\CouponDiscountTypeEnum;
use App\Enums\CustomerTypeEnum;
use App\Helpers\ImageHelper;
use App\Helpers\SendingResponse;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CustomerRepository implements CustomerInterface
{
    public function customer()
    {
        $customer = Customer::all();
        return SendingResponse::response('success', 'Customer Info', $customer, '', 200);
    }

    public function customerStore($request)
    {
        // working with customer type
        if ($request->customer_type == CustomerTypeEnum::SOCIAL->value) {
            $customerType = CustomerTypeEnum::SOCIAL->value;
        } else if ($request->customer_type == CustomerTypeEnum::WALKING->value) {
            $customerType = CustomerTypeEnum::WALKING->value;
        } else if ($request->customer_type == CustomerTypeEnum::ECOMMERCE->value) {
            $customerType = CustomerTypeEnum::ECOMMERCE->value;
        }

        $customer = Customer::create([
            'name'                              => $request->name,
            'email'                             => $request->email,
            'phone'                             => $request->phone,
            'gender'                            => $request->gender,
            'social_shop_id'                    => $request->social_shop_id,
            'registration_source'               => $request->registration_source,
            'customer_type'                     => $customerType,
            'user_id'                           => $request->user()->id,
            'pos_branch_id'                     => $request->pos_branch_id,
            'created_at'                        => Carbon::now(),
        ]);

        return SendingResponse::response('success', 'Customer Created', $customer, '', 200);
    }

    public function customerUpdate($request, $id)
    {
        $customer = Customer::findOrFail($id);

        // working with customer type
        if ($request->customer_type == CustomerTypeEnum::SOCIAL->value) {
            $customerType = CustomerTypeEnum::SOCIAL->value;
        } else if ($request->customer_type == CustomerTypeEnum::WALKING->value) {
            $customerType = CustomerTypeEnum::WALKING->value;
        } else if ($request->customer_type == CustomerTypeEnum::ECOMMERCE->value) {
            $customerType = CustomerTypeEnum::ECOMMERCE->value;
        }

        $customer->update([
            'name'                              => $request->name,
            'email'                             => $request->email,
            'phone'                             => $request->phone,
            'gender'                            => $request->gender,
            'social_shop_id'                    => $request->social_shop_id,
            'registration_source'               => $request->registration_source,
            'customer_type'                     => $customerType,
            'user_id'                           => $request->user()->id,
            'pos_branch_id'                     => $request->pos_branch_id,
        ]);

        if ($request->profile_picture != '') {
            if ($customer->profile_picture != '') {
                ImageHelper::removeImage($customer->profile_picture);
            }

            $profilePicture = ImageHelper::saveImage($request->profile_picture, '/uploads/customer/');

            $customer->update([
                'profile_picture'           => $profilePicture,
            ]);
        }

        return SendingResponse::response('success', 'Customer Updated', $customer, '', 200);
    }

    public function customerDelete($id)
    {
        $customer = Customer::findOrFail($id);

        if ($customer->profile_picture != '') {
            ImageHelper::removeImage($customer->profile_picture);
        }

        $customer->delete();

        return SendingResponse::response('success', 'Customer Deleted', '', '', 200);
    }

    public function customerShow($id)
    {
        $customer = Customer::findOrFail($id);

        return SendingResponse::response('success', 'Customer', $customer, '', 200);
    }
}
