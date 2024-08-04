<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\ProductRatingInterface;
use App\Enums\ProductReviewStatusEnum;
use App\Helpers\ImageHelper;
use App\Helpers\SendingResponse;
use App\Models\ProductRating;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProductRatingRepository implements ProductRatingInterface
{
    public function productRating()
    {
        $productRating = ProductRating::with(['user', 'product'])->get();
        return SendingResponse::response('success', 'Product Rating Info', $productRating, '', 200);
    }

    public function productRatingStore($request)
    {
        $productRatingId = ProductRating::insertGetId([
            'user_id'               => $request->user()->id,
            'product_id'            => $request->product_id,
            'rating'                => $request->rating,
            'created_at'            => Carbon::now(),
        ]);

        $productReview = ProductRating::findOrFail($productRatingId);

        return SendingResponse::response('success', 'Product Rating Created', $productReview, '', 200);
    }

    public function productRatingUpdate($request, $id)
    {
        $productRating = ProductRating::findOrFail($id);

        $productRating->update([
            'user_id'               => $request->user()->id,
            'product_id'            => $request->product_id,
            'rating'                => $request->rating,
        ]);

        return SendingResponse::response('success', 'Product Rating Updated', $productRating, '', 200);
    }

    public function productRatingDelete($id)
    {
        $productRating = ProductRating::findOrFail($id);

        $productRating->delete();

        return SendingResponse::response('success', 'Product Rating Deleted', '', '', 200);
    }

    public function productRatingShow($id)
    {
        $productRating = ProductRating::with(['user', 'product'])->findOrFail($id);

        return SendingResponse::response('success', 'Product Rating', $productRating, '', 200);
    }


    public function productRatingStatusUpdate($request)
    {
        $productRating = ProductRating::findOrFail($request->product_rating_id);

        // working with status
        if ($request->status == ProductReviewStatusEnum::PUBLISHED->value) {
            $productReviewStatus = ProductReviewStatusEnum::PUBLISHED->value;
        } else if ($request->status == ProductReviewStatusEnum::UNPUBLISHED->value) {
            $productReviewStatus = ProductReviewStatusEnum::UNPUBLISHED->value;
        }

        $productRating->update([
            'status'    => $productReviewStatus,
            'admin_id'  => $request->user()->id,
        ]);

        return SendingResponse::response('success', 'Product Rating Status Updated', $productRating, '', 200);
    }
}
