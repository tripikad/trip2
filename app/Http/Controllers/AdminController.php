<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use View;

use App\Image;

class AdminController extends Controller
{

    public function imageIndex()
    {

        $images = Image::orderBy('id', 'asc')->simplePaginate(96);
        
        return view('pages.image.index', [
            'images' => $images
        ]);

    }

}