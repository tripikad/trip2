<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class V2ImageController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $images = Image::doesntHave('user')
            ->orderBy('created_at', 'desc')
            ->take(25)
            ->get()
            ->map(function ($image) {
                return [
                    'title' => str_limit($image->filename, 20),
                    'small' => $image->preset('small_square'),
                    'large' => $image->preset('large'),
                    'id' => "[[$image->id]]",
                ];
            });

        return $images;
    }

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
