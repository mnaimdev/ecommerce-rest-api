<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\PosOrderInterface;
use App\Enums\CustomerTypeEnum;
use App\Enums\DeliveryTypeEnum;
use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentTypeEnum;
use App\Helpers\ImageHelper;
use App\Helpers\InvoiceHelper;
use App\Helpers\SendingResponse;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentInformation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PosOrderRepository implements PosOrderInterface
{
    public function posOrder()
    {
        $posOrder = Order::with(['orderItems', 'paymentInformations'])->get();
        return SendingResponse::response('success', 'Pos Order', $posOrder, '', 200);
    }

    public function posOrderStore($request)
    {
        try {
            DB::beginTransaction();

            if (!empty($request->coupon_code)) {
                $couponId = Coupon::where('code', $request->coupon_code)->first()->id;
            }

            // working with delivery type
            if ($request->delivery_type == DeliveryTypeEnum::OWNDELIVERY->value) {
                $deliveryType = DeliveryTypeEnum::OWNDELIVERY->value;
            } else if ($request->delivery_type == DeliveryTypeEnum::COURIERSERVICE->value) {
                $deliveryType = DeliveryTypeEnum::COURIERSERVICE->value;
            }
            if ($request->delivery_type == DeliveryTypeEnum::SELFRECEIVE->value) {
                $deliveryType = DeliveryTypeEnum::SELFRECEIVE->value;
            }


            // working with social order
            if ($request->customer_type == CustomerTypeEnum::SOCIAL->value) {
                $socialOrderType = CustomerTypeEnum::SOCIAL->value;
                $invoiceNumber = InvoiceHelper::generateInvoice($socialOrderType);

                $posOrder = Order::create([
                    'customer_id'                   => $request->customer_id,
                    'shipping_address_id'           => $request->shipping_address_id,
                    'admin_id'                      => $request->user()->id,
                    'coupon_id'                     => $couponId,
                    'pos_branch_id'                 => $request->pos_branch_id,
                    'delivery_charge_id'            => $request->delivery_charge_id,
                    'social_shop_id'                => $request->social_shop_id,
                    'order_status_id'               => $request->order_status_id,
                    'order_type'                    => $socialOrderType,
                    'invoice_no'                    => $invoiceNumber,
                    'delivery_type'                 => $deliveryType,
                    'delivery_date'                 => $request->delivery_date,
                    'subtotal'                      => $request->subtotal,
                    'delivery_charge'               => $request->delivery_charge,
                    'tax_amount'                    => $request->tax_amount,
                    'discount_amount'               => $request->discount_amount,
                    'total_amount'                  => $request->total_amount,
                    'note'                          => $request->note,
                    'print_status'                  => $request->print_status,
                    'created_at'                    => Carbon::now(),
                ]);

                if ($request->print_status == 1) {
                    $posOrder->update([
                        'print_count'           => $posOrder->print_count + 1,
                    ]);
                }

                if (!empty($request->payment_informations)) {
                    $paymentInfo = $request->payment_informations;

                    // payment status
                    if ($paymentInfo['payment_type'] == PaymentTypeEnum::FULL->value) {
                        $paymentType = PaymentTypeEnum::FULL->value;
                    } else if ($paymentInfo['payment_type'] == PaymentTypeEnum::PARTIAL->value) {
                        $paymentType = PaymentTypeEnum::PARTIAL->value;
                    }
                    // payment method
                    if ($paymentInfo['payment_method'] == PaymentMethodEnum::CASHONDELIVERY->value) {
                        $paymentMethod = PaymentMethodEnum::CASHONDELIVERY->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::CASHPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::CASHPAYMENT->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::CARDPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::CARDPAYMENT->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::ONLINEPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::ONLINEPAYMENT->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::BANKTRANSFER->value) {
                        $paymentMethod = PaymentMethodEnum::BANKTRANSFER->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::MOBILEPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::MOBILEPAYMENT->value;
                    }

                    PaymentInformation::create([
                        'order_id'              => $posOrder->id,
                        'payment_type'          => $paymentType,
                        'payment_amount'        => $paymentInfo['payment_amount'],
                        'payment_method'        => $paymentMethod,
                        'payment_method_name'   => $paymentInfo['payment_method_name'],
                        'account_no'            => $paymentInfo['account_no'],
                        'transaction_no'        => $paymentInfo['transaction_no'],
                    ]);
                }

                if (!empty($request->order_items)) {
                    $orderItems = $request->order_items;

                    foreach ($orderItems as $orderItem) {
                        OrderItem::create([
                            'order_id'                  => $posOrder->id,
                            "product_id"                => $orderItem['product_id'],
                            "product_variant_id"        => $orderItem['product_variant_id'],
                            "quantity"                  => $orderItem['quantity'],
                            "price"                     => $orderItem['price'],
                            "sale_price"                => $orderItem['sale_price'],
                            "discount_amount"           => $orderItem['discount_amount'],
                            "final_price"               => $orderItem['final_price'],
                        ]);
                    }
                }
            }

            // working with walking order
            else if ($request->customer_type == CustomerTypeEnum::WALKING->value) {
                $WalkingOrderType = CustomerTypeEnum::WALKING->value;
                $invoiceNumber = InvoiceHelper::generateInvoice($WalkingOrderType);

                $posOrder = Order::create([
                    'customer_id'                   => $request->customer_id,
                    'admin_id'                      => $request->user()->id,
                    'coupon_id'                     => $couponId,
                    'pos_branch_id'                 => $request->pos_branch_id,
                    'delivery_charge_id'            => $request->delivery_charge_id,
                    'order_status_id'               => $request->order_status_id,
                    'order_type'                    => $WalkingOrderType,
                    'invoice_no'                    => $invoiceNumber,
                    'subtotal'                      => $request->subtotal,
                    'tax_amount'                    => $request->tax_amount,
                    'discount_amount'               => $request->discount_amount,
                    'total_amount'                  => $request->total_amount,
                    'note'                          => $request->note,
                    'print_status'                  => $request->print_status,
                    'created_at'                    => Carbon::now(),
                ]);

                if ($request->print_status == 1) {
                    $posOrder->update([
                        'print_count'           => $posOrder->print_count + 1,
                    ]);
                }

                if (!empty($request->payment_informations)) {
                    $paymentInfo = $request->payment_informations;

                    // payment status
                    if ($paymentInfo['payment_type'] == PaymentTypeEnum::FULL->value) {
                        $paymentType = PaymentTypeEnum::FULL->value;
                    } else if ($paymentInfo['payment_type'] == PaymentTypeEnum::PARTIAL->value) {
                        $paymentType = PaymentTypeEnum::PARTIAL->value;
                    }
                    // payment method
                    if ($paymentInfo['payment_method'] == PaymentMethodEnum::CASHONDELIVERY->value) {
                        $paymentMethod = PaymentMethodEnum::CASHONDELIVERY->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::CASHPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::CASHPAYMENT->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::CARDPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::CARDPAYMENT->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::ONLINEPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::ONLINEPAYMENT->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::BANKTRANSFER->value) {
                        $paymentMethod = PaymentMethodEnum::BANKTRANSFER->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::MOBILEPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::MOBILEPAYMENT->value;
                    }

                    PaymentInformation::create([
                        'order_id'              => $posOrder->id,
                        'payment_type'          => $paymentType,
                        'payment_amount'        => $paymentInfo['payment_amount'],
                        'payment_method'        => $paymentMethod,
                        'payment_method_name'   => $paymentInfo['payment_method_name'],
                        'account_no'            => $paymentInfo['account_no'],
                        'transaction_no'        => $paymentInfo['transaction_no'],
                    ]);
                }

                if (!empty($request->order_items)) {
                    $orderItems = $request->order_items;

                    foreach ($orderItems as $orderItem) {
                        OrderItem::create([
                            'order_id'                  => $posOrder->id,
                            "product_id"                => $orderItem['product_id'],
                            "product_variant_id"        => $orderItem['product_variant_id'],
                            "quantity"                  => $orderItem['quantity'],
                            "price"                     => $orderItem['price'],
                            "sale_price"                => $orderItem['sale_price'],
                            "discount_amount"           => $orderItem['discount_amount'],
                            "final_price"               => $orderItem['final_price'],
                        ]);
                    }
                }
            }

            DB::commit();

            return SendingResponse::response('success', 'Pos Order Created', $posOrder, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
            DB::rollBack();
        }
    }

    public function posOrderUpdate($request, $id)
    {
        try {
            DB::beginTransaction();

            if (!empty($request->coupon_code)) {
                $couponId = Coupon::where('code', $request->coupon_code)->first()->id;
            }

            // working with delivery type
            if ($request->delivery_type == DeliveryTypeEnum::OWNDELIVERY->value) {
                $deliveryType = DeliveryTypeEnum::OWNDELIVERY->value;
            } else if ($request->delivery_type == DeliveryTypeEnum::COURIERSERVICE->value) {
                $deliveryType = DeliveryTypeEnum::COURIERSERVICE->value;
            }
            if ($request->delivery_type == DeliveryTypeEnum::SELFRECEIVE->value) {
                $deliveryType = DeliveryTypeEnum::SELFRECEIVE->value;
            }

            $posOrder = Order::findOrFail($id);

            // working with social order
            if ($request->customer_type == CustomerTypeEnum::SOCIAL->value) {
                $socialOrderType = CustomerTypeEnum::SOCIAL->value;
                $invoiceNumber = InvoiceHelper::generateInvoice($socialOrderType);

                $posOrder->update([
                    'customer_id'                   => $request->customer_id,
                    'shipping_address_id'           => $request->shipping_address_id,
                    'admin_id'                      => $request->user()->id,
                    'coupon_id'                     => $couponId,
                    'pos_branch_id'                 => $request->pos_branch_id,
                    'delivery_charge_id'            => $request->delivery_charge_id,
                    'social_shop_id'                => $request->social_shop_id,
                    'order_status_id'               => $request->order_status_id,
                    'order_type'                    => $socialOrderType,
                    'invoice_no'                    => $invoiceNumber,
                    'delivery_type'                 => $deliveryType,
                    'delivery_date'                 => $request->delivery_date,
                    'subtotal'                      => $request->subtotal,
                    'delivery_charge'               => $request->delivery_charge,
                    'tax_amount'                    => $request->tax_amount,
                    'discount_amount'               => $request->discount_amount,
                    'total_amount'                  => $request->total_amount,
                    'note'                          => $request->note,
                    'print_status'                  => $request->print_status,
                ]);

                if ($request->print_status == 1) {
                    $posOrder->update([
                        'print_count'           => $posOrder->print_count + 1,
                    ]);
                }

                if (!empty($request->payment_informations)) {
                    $paymentInfo = $request->payment_informations;

                    // payment status
                    if ($paymentInfo['payment_type'] == PaymentTypeEnum::FULL->value) {
                        $paymentType = PaymentTypeEnum::FULL->value;
                    } else if ($paymentInfo['payment_type'] == PaymentTypeEnum::PARTIAL->value) {
                        $paymentType = PaymentTypeEnum::PARTIAL->value;
                    }
                    // payment method
                    if ($paymentInfo['payment_method'] == PaymentMethodEnum::CASHONDELIVERY->value) {
                        $paymentMethod = PaymentMethodEnum::CASHONDELIVERY->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::CASHPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::CASHPAYMENT->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::CARDPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::CARDPAYMENT->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::ONLINEPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::ONLINEPAYMENT->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::BANKTRANSFER->value) {
                        $paymentMethod = PaymentMethodEnum::BANKTRANSFER->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::MOBILEPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::MOBILEPAYMENT->value;
                    }

                    PaymentInformation::create([
                        'order_id'              => $posOrder->id,
                        'payment_type'          => $paymentType,
                        'payment_amount'        => $paymentInfo['payment_amount'],
                        'payment_method'        => $paymentMethod,
                        'payment_method_name'   => $paymentInfo['payment_method_name'],
                        'account_no'            => $paymentInfo['account_no'],
                        'transaction_no'        => $paymentInfo['transaction_no'],
                    ]);
                }

                if (!empty($request->order_items)) {
                    $orderItems = $request->order_items;

                    OrderItem::where('order_id', $posOrder->id)->delete();

                    foreach ($orderItems as $orderItem) {
                        OrderItem::create([
                            'order_id'                  => $posOrder->id,
                            "product_id"                => $orderItem['product_id'],
                            "product_variant_id"        => $orderItem['product_variant_id'],
                            "quantity"                  => $orderItem['quantity'],
                            "price"                     => $orderItem['price'],
                            "sale_price"                => $orderItem['sale_price'],
                            "discount_amount"           => $orderItem['discount_amount'],
                            "final_price"               => $orderItem['final_price'],
                        ]);
                    }
                }
            }

            // working with walking order
            else if ($request->customer_type == CustomerTypeEnum::WALKING->value) {
                $WalkingOrderType = CustomerTypeEnum::WALKING->value;
                $invoiceNumber = InvoiceHelper::generateInvoice($WalkingOrderType);

                $posOrder->update([
                    'customer_id'                   => $request->customer_id,
                    'admin_id'                      => $request->user()->id,
                    'coupon_id'                     => $couponId,
                    'pos_branch_id'                 => $request->pos_branch_id,
                    'order_status_id'               => $request->order_status_id,
                    'order_type'                    => $WalkingOrderType,
                    'invoice_no'                    => $invoiceNumber,
                    'subtotal'                      => $request->subtotal,
                    'tax_amount'                    => $request->tax_amount,
                    'discount_amount'               => $request->discount_amount,
                    'total_amount'                  => $request->total_amount,
                    'note'                          => $request->note,
                    'print_status'                  => $request->print_status,
                ]);

                if ($request->print_status == 1) {
                    $posOrder->update([
                        'print_count'           => $posOrder->print_count + 1,
                    ]);
                }

                if (!empty($request->payment_informations)) {
                    $paymentInfo = $request->payment_informations;

                    // payment status
                    if ($paymentInfo['payment_type'] == PaymentTypeEnum::FULL->value) {
                        $paymentType = PaymentTypeEnum::FULL->value;
                    } else if ($paymentInfo['payment_type'] == PaymentTypeEnum::PARTIAL->value) {
                        $paymentType = PaymentTypeEnum::PARTIAL->value;
                    }
                    // payment method
                    if ($paymentInfo['payment_method'] == PaymentMethodEnum::CASHONDELIVERY->value) {
                        $paymentMethod = PaymentMethodEnum::CASHONDELIVERY->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::CASHPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::CASHPAYMENT->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::CARDPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::CARDPAYMENT->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::ONLINEPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::ONLINEPAYMENT->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::BANKTRANSFER->value) {
                        $paymentMethod = PaymentMethodEnum::BANKTRANSFER->value;
                    } else if ($paymentInfo['payment_method'] == PaymentMethodEnum::MOBILEPAYMENT->value) {
                        $paymentMethod = PaymentMethodEnum::MOBILEPAYMENT->value;
                    }

                    PaymentInformation::create([
                        'order_id'              => $posOrder->id,
                        'payment_type'          => $paymentType,
                        'payment_amount'        => $paymentInfo['payment_amount'],
                        'payment_method'        => $paymentMethod,
                        'payment_method_name'   => $paymentInfo['payment_method_name'],
                        'account_no'            => $paymentInfo['account_no'],
                        'transaction_no'        => $paymentInfo['transaction_no'],
                    ]);
                }

                if (!empty($request->order_items)) {
                    $orderItems = $request->order_items;

                    OrderItem::where('order_id', $posOrder->id)->delete();

                    foreach ($orderItems as $orderItem) {
                        OrderItem::create([
                            'order_id'                  => $posOrder->id,
                            "product_id"                => $orderItem['product_id'],
                            "product_variant_id"        => $orderItem['product_variant_id'],
                            "quantity"                  => $orderItem['quantity'],
                            "price"                     => $orderItem['price'],
                            "sale_price"                => $orderItem['sale_price'],
                            "discount_amount"           => $orderItem['discount_amount'],
                            "final_price"               => $orderItem['final_price'],
                        ]);
                    }
                }
            }

            DB::commit();

            return SendingResponse::response('success', 'Pos Order Updated', $posOrder, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
            DB::rollBack();
        }
    }

    public function posOrderDelete($id)
    {
        $posOrder = Order::findOrFail($id);

        $posOrder->delete();

        return SendingResponse::response('success', 'Pos Order Deleted', '', '', 200);
    }

    public function posOrderShow($id)
    {
        $posOrder = Order::with(['orderItems', 'paymentInformations'])->findOrFail($id);

        return SendingResponse::response('success', 'Pos Order', $posOrder, '', 200);
    }
}
