<?php

namespace App\Http\Controllers;

use App\Content;
use Illuminate\Http\JsonResponse;

class ContentController extends Controller
{
    public function redirectIndex($type)
    {
        return redirect()->route("$type.index", [], 301);
    }

    public function redirectShow($type, $id)
    {
        $content = Content::findOrFail($id);

        return redirect()->route("$type.show", [$content->slug], 301);
    }

    public function status($type, $id, $status)
    {
        $content = Content::findorFail($id);

        if ($status == 0 || $status == 1) {
            $content->status = $status;
            $content->save();

            if (request()->ajax()) {
                return new JsonResponse(trans("content.action.status.$status.info", ['title' => $content->title]));
            } else {
                return back()->with(
          'info',
          trans("content.action.status.$status.info", [
            'title' => $content->title
          ])
        );
            }
        }

        if (request()->ajax()) {
            return new JsonResponse('Invalid status', 403);
        } else {
            return back();
        }
    }
}
