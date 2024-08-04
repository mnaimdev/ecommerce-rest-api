<?php

namespace App\Contracts\Dashboard;

interface FaqInterface
{
    public function faq();
    public function faqStore($request);
    public function faqUpdate($request, $id);
    public function faqDelete($id);
    public function faqShow($id);
}
