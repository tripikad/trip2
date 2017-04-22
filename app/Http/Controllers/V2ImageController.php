<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class V2ImageController extends Controller
{
    public function store(Request $request)
    {
        // Converting MB to KB

        $maxfilesize = config('site.maxfilesize') * 1024;

        $this->validate($request, [
            'image' => "required|image|max:$maxfilesize",
        ]);

        $filename = Image::storeImageFile($request->file('image'));
        $image = Image::create(['filename' => $filename]);

        if ($request->ajax()) {
            return $image;
        }

        return back();
    }
}
