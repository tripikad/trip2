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
}
