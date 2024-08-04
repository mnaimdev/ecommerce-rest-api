<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\PosCustomerInterface;
use App\Enums\PosCustomerTypeEnum;
use App\Helpers\SendingResponse;
use App\Models\Customer;
use App\Models\ShippingAddress;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosCustomerRepository implements PosCustomerInterface
{
    public function posCustomer()
    {
        $posCustomer = Customer::with('shippingAddress')->get();
        return SendingResponse::response('success', 'Pos Customer Info', $posCustomer, '', 200);
    }

    public function posCustomerStore($request)
    {
        try {
            DB::beginTransaction();

            if ($request->customer_type == PosCustomerTypeEnum::WALKING->value) {
                $customerTypeWalking = PosCustomerTypeEnum::WALKING->value;

                $request->validate([
                    'phone'                         => 'required',
                    'customer_type'                 => 'required',
                    'pos_branch_id'                 => 'required',
                ]);

                $customer = Customer::create([
                    'phone'                             => $request->phone,
                    'customer_type'                     => $customerTypeWalking,
                    'user_id'                           => $request->user()->id,
                    'pos_branch_id'                     => $request->pos_branch_id,
                    'created_at'                        => Carbon::now(),
                ]);
            }

            // else if
            else if ($request->customer_type == PosCustomerTypeEnum::SOCIAL->value) {
                $customerTypeSocial = PosCustomerTypeEnum::SOCIAL->value;

                $request->validate([
                    'name'                          => 'required',
                    'phone'                         => 'required',
                    'customer_type'                 => 'required',
                    'pos_branch_id'                 => 'required',
                    'social_shop_id'                => 'required',
                ]);

                $customer = Customer::create([
                    'name'                              => $request->name,
                    'email'                             => $request->email,
                    'phone'                             => $request->phone,
                    'gender'                            => $request->gender,
                    'social_shop_id'                    => $request->social_shop_id,
                    'registration_source'               => $request->registration_source,
                    'customer_type'                     => $customerTypeSocial,
                    'user_id'                           => $request->user()->id,
                    'pos_branch_id'                     => $request->pos_branch_id,
                    'created_at'                        => Carbon::now(),
                ]);

                if (!empty($request->shipping_address)) {
                    $shippingAddress = $request->shipping_address;

                    ShippingAddress::create([
                        'user_id'               => $request->user()->id,
                        'customer_id'           => $customer->id,
                        'phone'                 => $shippingAddress['phone'],
                        'alternative_phone'     => $shippingAddress['alternative_phone'],
                        'email'                 => $shippingAddress['email'],
                        'country'               => $shippingAddress['country'],
                        'state'                 => $shippingAddress['state'],
                        'city'                  => $shippingAddress['city'],
                        'address'               => $shippingAddress['address'],
                        'latitude'              => $shippingAddress['latitude'],
                        'longitude'             => $shippingAddress['longitude'],
                        'status'                => $shippingAddress['status'],
                        'created_at'            => Carbon::now(),
                    ]);
                }
            }

            DB::commit();

            return SendingResponse::response('success', 'Customer Created', $customer, '', 200);
        } catch (\Exception $e) {
            DB::rollback();
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function posCustomerUpdate($request, $id)
    {
        try {
            DB::beginTransaction();

            $customer = Customer::findOrFail($id);

            if ($request->customer_type == PosCustomerTypeEnum::WALKING->value) {
                $customerTypeWalking = PosCustomerTypeEnum::WALKING->value;

                $request->validate([
                    'phone'                         => 'required',
                    'customer_type'                 => 'required',
                    'pos_branch_id'                 => 'required',
                ]);

                $customer->update([
                    'phone'                             => $request->phone,
                    'customer_type'                     => $customerTypeWalking,
                    'user_id'                           => $request->user()->id,
                    'pos_branch_id'                     => $request->pos_branch_id,
                ]);
            } else if ($request->customer_type == PosCustomerTypeEnum::SOCIAL->value) {
                $customerTypeSocial = PosCustomerTypeEnum::SOCIAL->value;

                $request->validate([
                    'name'                          => 'required',
                    'phone'                         => 'required',
                    'customer_type'                 => 'required',
                    'pos_branch_id'                 => 'required',
                    'social_shop_id'                => 'required',
                ]);

                $customer->update([
                    'name'                              => $request->name,
                    'email'                             => $request->email,
                    'phone'                             => $request->phone,
                    'gender'                            => $request->gender,
                    'social_page_id'                    => $request->social_page_id,
                    'registration_source'               => $request->registration_source,
                    'customer_type'                     => $customerTypeSocial,
                    'user_id'                           => $request->user()->id,
                    'pos_branch_id'                     => $request->pos_branch_id,
                ]);
            }

            DB::commit();

            return SendingResponse::response('success', 'Customer Updated', $customer, '', 200);
        } catch (\Exception $e) {
            DB::rollback();
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function posCustomerShow($id)
    {
        $posCustomer = Customer::with('shippingAddress')->findOrFail($id);

        return SendingResponse::response('success', 'Pos Customer', $posCustomer, '', 200);
    }

    public function searchCustomer($request)
    {
        $request->validate([
            'phone'     => 'required',
        ]);

        $customer = Customer::where('phone', 'LIKE', '%' . $request->phone . '%')->with('shippingAddress')->get();

        return SendingResponse::response('success', 'Customer', $customer, '', 200);
    }
}
