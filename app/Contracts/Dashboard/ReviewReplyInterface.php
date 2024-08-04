<?php

namespace App\Contracts\Dashboard;

interface ReviewReplyInterface
{
    public function reviewReply();
    public function reviewReplyStore($request);
    public function reviewReplyUpdate($request, $id);
    public function reviewReplyDelete($id);
    public function reviewReplyShow($id);
    public function reviewReplyStatusUpdate($request);
}
