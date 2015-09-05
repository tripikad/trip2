<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Image;

class ImageController extends Controller
{

    public function index()
    {

        $images = Image::orderBy('id', 'asc')->simplePaginate(24);
        
        return view('pages.image.index', [
            'images' => $images
        ]);

    }

}