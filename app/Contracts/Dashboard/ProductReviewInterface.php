<?php

namespace App\Contracts\Dashboard;

interface ProductReviewInterface
{
    public function productReview();
    public function productReviewStore($request);
    public function productReviewUpdate($request, $id);
    public function productReviewDelete($id);
    public function productReviewShow($id);
    public function productReviewStatusUpdate($request);
    public function productReviewReplies($id);
}
