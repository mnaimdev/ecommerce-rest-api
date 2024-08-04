<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\TagInterface;
use App\Helpers\SendingResponse;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TagRepository implements TagInterface
{
    public function tag()
    {
        $tags = Tag::all();
        return SendingResponse::response('success', 'Tag Info', $tags, '', 200);
    }

    public function tagStore($request)
    {
        $tag = Tag::create([
            'name'                  => $request->name,
            'slug'                  => $request->slug,
            'status'                => $request->status,
            'user_id'               => $request->user()->id,
            'created_at'            => Carbon::now(),
        ]);

        return SendingResponse::response('success', 'Tag Created', $tag, '', 200);
    }

    public function tagUpdate($request, $id)
    {

        $tag = Tag::findOrFail($id);

        $tag->update([
            'user_id'               => $request->user()->id,
            'name'                  => $request->name,
            'slug'                  => $request->slug,
            'status'                => $request->status,
        ]);

        return SendingResponse::response('success', 'Tag Updated', $tag, '', 200);
    }

    public function tagDelete($id)
    {
        $tag = Tag::findOrFail($id);

        $tag->delete();

        return SendingResponse::response('success', 'Tag Deleted', '', '', 200);
    }

    public function tagShow($id)
    {
        $tag = Tag::findOrFail($id);

        return SendingResponse::response('success', 'Tag', $tag, '', 200);
    }
}
