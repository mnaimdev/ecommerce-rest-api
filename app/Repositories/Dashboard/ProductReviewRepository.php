<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\ProductReviewInterface;
use App\Enums\ProductReviewStatusEnum;
use App\Helpers\ImageHelper;
use App\Helpers\SendingResponse;
use App\Models\ProductReview;
use App\Models\ProductReviewImage;
use Carbon\Carbon;

class ProductReviewRepository implements ProductReviewInterface
{
    public function productReview()
    {
        $productReview = ProductReview::with([
            'user:id,name,phone,image',
            'product:id,name,thumbnail_image',
        ])
            ->withCount('productReviewReplies')
            ->get();
        return SendingResponse::response('success', 'Product Review Info', $productReview, '', 200);
    }

    public function productReviewStore($request)
    {
        $productReviewId = ProductReview::insertGetId([
            'user_id'               => $request->user()->id,
            'product_id'            => $request->product_id,
            'review'                => $request->review,
            'created_at'            => Carbon::now(),
        ]);

        $productReview = ProductReview::findOrFail($productReviewId);

        // insert data into product images
        $productReviewImages = $request->image;
        if (!empty($productReviewImages)) {
            foreach ($productReviewImages as $productReviewImage) {
                $image = ImageHelper::saveImage($productReviewImage['image'], '/uploads/review/');

                ProductReviewImage::create([
                    'product_review_id'    => $productReview->id,
                    'image'                => $image,
                ]);
            }
        }

        return SendingResponse::response('success', 'Product Review Created', $productReview, '', 200);
    }

    public function productReviewUpdate($request, $id)
    {
        $productReview = ProductReview::findOrFail($id);

        $productReview->update([
            'user_id'               => $request->user()->id,
            'product_id'            => $request->product_id,
            'review'                => $request->review,
        ]);

        // insert data into product images
        $productReviewImages = $request->image;
        if (!empty($productReviewImages)) {

            // remove previous image if they stay
            $productReviewImageGalleries = ProductReviewImage::where('product_review_id', $productReview->id)->get();
            foreach ($productReviewImageGalleries as $gallery) {
                if ($gallery->image != '') {
                    ImageHelper::removeImage($gallery->image);
                }
            }
            ProductReviewImage::where('product_review_id', $productReview->id)->delete();

            foreach ($productReviewImages as $productReviewImage) {
                $image = ImageHelper::saveImage($productReviewImage['image'], '/uploads/review/');

                ProductReviewImage::create([
                    'product_review_id'    => $productReview->id,
                    'image'                => $image,
                ]);
            }
        }

        return SendingResponse::response('success', 'Product Review Updated', $productReview, '', 200);
    }

    public function productReviewDelete($id)
    {
        $productReview = ProductReview::findOrFail($id);

        // remove product gallery image
        $productReviewImageGalleries = ProductReviewImage::where('product_review_id', $productReview->id)
            ->get();
        foreach ($productReviewImageGalleries as $gallery) {
            if ($gallery->image != '') {
                ImageHelper::removeImage($gallery->image);
            }
        }
        $productReview->delete();

        return SendingResponse::response('success', 'Product Review Deleted', '', '', 200);
    }

    public function productReviewShow($id)
    {
        $productReview = ProductReview::with(['user', 'product', 'productReviewImage'])->findOrFail($id);

        return SendingResponse::response('success', 'Product Review', $productReview, '', 200);
    }


    public function productReviewStatusUpdate($request)
    {
        $productReview = ProductReview::findOrFail($request->product_review_id);

        // working with status
        if ($request->status == ProductReviewStatusEnum::PUBLISHED->value) {
            $productReviewStatus = ProductReviewStatusEnum::PUBLISHED->value;
        } else if ($request->status == ProductReviewStatusEnum::UNPUBLISHED->value) {
            $productReviewStatus = ProductReviewStatusEnum::UNPUBLISHED->value;
        }

        $productReview->update([
            'status'    => $productReviewStatus,
            'admin_id'  => $request->user()->id,
        ]);

        return SendingResponse::response('success', 'Product Review Status Updated', $productReview, '', 200);
    }

    public function productReviewReplies($id)
    {
        $productReview = ProductReview::select('id', 'user_id', 'review', 'status')->with(['user:id,name,phone,image', 'productReviewImages', 'productReviewReplies:id,user_id,reply,status', 'productReviewReplies.user:id,name,image,phone', 'productReviewReplies.reviewReplyImage'])->findOrFail($id);

        return SendingResponse::response('success', 'Product Review Replies', $productReview, '', 200);
    }
}
