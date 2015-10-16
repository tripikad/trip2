<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Image;
use App\Content;

class AdminController extends Controller
{
    public function imageIndex()
    {
        $images = Image::orderBy('id', 'asc')->simplePaginate(96);

        return view('pages.admin.image.index', [
            'images' => $images,
        ]);
    }

    public function imageStore(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image',
        ]);

        $filename = Image::storeImageFile($request->file('image'));
        Image::create(['filename' => $filename]);

        return back()
            ->with('info', trans('admin.image.store.info', [
                    'filename' => $filename,
            ]));
    }

    public function contentIndex()
    {
        $contents = Content::with(['user', 'comments'])
            ->latest('created_at')
            ->whereStatus(0)
            ->simplePaginate(50);

        return response()->view('pages.admin.content.index', [
            'contents' => $contents,
        ]);
    }
}
