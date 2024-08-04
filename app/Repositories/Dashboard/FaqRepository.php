<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\FaqInterface;
use App\Helpers\SendingResponse;
use App\Models\Faq;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FaqRepository implements FaqInterface
{
    public function faq()
    {
        $faq = Faq::all();
        return SendingResponse::response('success', 'Faq Info', $faq, '', 200);
    }

    public function faqStore($request)
    {
        $faq = Faq::create([
            'question'              => $request->question,
            'answer'                => $request->answer,
            'user_id'               => $request->user()->id,
            'created_at'            => Carbon::now(),
        ]);

        return SendingResponse::response('success', 'Faq Created', $faq, '', 200);
    }

    public function faqUpdate($request, $id)
    {
        $faq = Faq::findOrFail($id);

        $faq->update([
            'question'              => $request->question,
            'answer'                => $request->answer,
            'user_id'               => $request->user()->id,
        ]);

        return SendingResponse::response('success', 'Faq Updated', $faq, '', 200);
    }

    public function faqDelete($id)
    {
        $faq = Faq::findOrFail($id);

        $faq->delete();

        return SendingResponse::response('success', 'Faq Deleted', '', '', 200);
    }

    public function faqShow($id)
    {
        $faq = Faq::findOrFail($id);

        return SendingResponse::response('success', 'Faq', $faq, '', 200);
    }
}
