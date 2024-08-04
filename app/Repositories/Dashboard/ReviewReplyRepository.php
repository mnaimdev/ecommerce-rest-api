<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\ReviewReplyInterface;
use App\Enums\ProductReviewStatusEnum;
use App\Helpers\ImageHelper;
use App\Helpers\SendingResponse;
use App\Models\ReviewReply;
use App\Models\ReviewReplyImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReviewReplyRepository implements ReviewReplyInterface
{
    public function reviewReply()
    {
        $reviewReply = ReviewReply::with(['user', 'productReview', 'reviewReplyImage'])->get();
        return SendingResponse::response('success', 'Review Reply Info', $reviewReply, '', 200);
    }

    public function reviewReplyStore($request)
    {
        $reviewReplyId = ReviewReply::insertGetId([
            'user_id'               => $request->user()->id,
            'product_review_id'     => $request->product_review_id,
            'reply'                 => $request->reply,
            'created_at'            => Carbon::now(),
        ]);

        $reviewReply = ReviewReply::findOrFail($reviewReplyId);

        // insert data into product images
        $reviewReplyImages = $request->image;
        if (!empty($reviewReplyImages)) {
            foreach ($reviewReplyImages as $reviewReplyImage) {
                $image = ImageHelper::saveImage($reviewReplyImage['image'], '/uploads/review/reply/');

                ReviewReplyImage::create([
                    'review_reply_id'    => $reviewReply->id,
                    'image'              => $image,
                ]);
            }
        }

        return SendingResponse::response('success', 'Review Reply Created', $reviewReply, '', 200);
    }

    public function reviewReplyUpdate($request, $id)
    {
        $reviewReply = ReviewReply::findOrFail($id);

        $reviewReply->update([
            'user_id'               => $request->user()->id,
            'product_review_id'     => $request->product_review_id,
            'reply'                 => $request->reply,
        ]);

        // insert data into product images
        $reviewReplyImages = $request->image;
        if (!empty($reviewReplyImages)) {

            // remove previous image if they stay
            $reviewReplyImageGalleries = ReviewReplyImage::where('review_reply_id', $reviewReply->id)->get();
            foreach ($reviewReplyImageGalleries as $gallery) {
                if ($gallery->image != '') {
                    ImageHelper::removeImage($gallery->image);
                }
            }
            ReviewReplyImage::where('review_reply_id', $reviewReply->id)->delete();

            foreach ($reviewReplyImages as $reviewReplyImage) {
                $image = ImageHelper::saveImage($reviewReplyImage['image'], '/uploads/review/reply/');

                ReviewReplyImage::create([
                    'review_reply_id'    => $reviewReply->id,
                    'image'              => $image,
                ]);
            }
        }

        return SendingResponse::response('success', 'Review Reply Updated', $reviewReply, '', 200);
    }

    public function reviewReplyDelete($id)
    {
        $reviewReply = ReviewReply::findOrFail($id);

        // remove product gallery image
        $reviewReplyImageGalleries = ReviewReplyImage::where('review_reply_id', $reviewReply->id)
            ->get();
        foreach ($reviewReplyImageGalleries as $gallery) {
            if ($gallery->image != '') {
                ImageHelper::removeImage($gallery->image);
            }
        }
        $reviewReply->delete();

        return SendingResponse::response('success', 'Review Reply Deleted', '', '', 200);
    }

    public function reviewReplyShow($id)
    {
        $reviewReply = ReviewReply::with(['user', 'productReview', 'reviewReplyImage'])->findOrFail($id);

        return SendingResponse::response('success', 'Review Reply', $reviewReply, '', 200);
    }

    public function reviewReplyStatusUpdate($request)
    {
        $reviewReply = ReviewReply::findOrFail($request->review_reply_id);

        // working with status
        if ($request->status == ProductReviewStatusEnum::PUBLISHED->value) {
            $productReviewStatus = ProductReviewStatusEnum::PUBLISHED->value;
        } else if ($request->status == ProductReviewStatusEnum::UNPUBLISHED->value) {
            $productReviewStatus = ProductReviewStatusEnum::UNPUBLISHED->value;
        }

        $reviewReply->update([
            'status'    => $productReviewStatus,
            'admin_id'  => $request->user()->id,
        ]);

        return SendingResponse::response('success', 'Review Reply Status Updated', $reviewReply, '', 200);
    }
}
