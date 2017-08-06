<?php

namespace App\Http\Controllers;

use App\Content;

class V2ContentController extends Controller
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

            return back()->with('info', trans("content.action.status.$status.info", [
                'title' => $content->title,
            ]));
        }

        return back();
    }

}
