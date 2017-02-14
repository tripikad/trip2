<?php

namespace App\Http\Controllers;

use DB;
use App\Image;
use App\Content;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /*
    public function imageIndex()
    {
        $exception = [
            'contents.type' => 'photo',
            'imageable_type' => 'App\User',
        ];

        $user_image_ids = DB::table('imageables')
            ->where('imageable_type', '=', 'App\User')
            ->pluck('image_id');

        $photo_ids = DB::table('imageables')
            ->join('contents', 'contents.id', '=', 'imageables.imageable_id')
            ->where('imageables.imageable_type', '=', 'App\Content')
            ->where('contents.type', '=', 'photo')
            ->pluck('imageables.image_id');

        $images = Image::whereNotIn('id', $user_image_ids)
            ->whereNotIn('id', $photo_ids)
            ->orderBy('created_at', 'desc')
            ->simplePaginate(96);

        return view('pages.admin.image.index', [
            'images' => $images,
        ]);
    }
    */
    /*public function imageStore(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image',
        ]);

        $filename = Image::storeImageFile($request->file('image'));
        $orig_filename = $request->file('image')->getClientOriginalName();
        Image::create(['filename' => $filename]);

        if (! $request->ajax()) {
            return back()
                ->with('info', trans('admin.image.store.info', [
                    'filename' => $orig_filename,
                ]));
        }
    }*/

    /*
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
    */
}
