<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use View;

use App\Image;
use App\Content;
use Validator;
use App\Http\Controllers\ContentController;


class ImageController extends Controller
{

	public function store(Request $request)
    {
    	$this->validate($request, [
        	'image' => 'required|image'
    	]);

        //save
        $filename = Image::storeImage($request->file('image'));
        Image::create(['filename' => $filename]);

        return redirect()
            ->route('admin.image.index')
            ->with('info', trans('image.store.info', [
                    'imagename' => $filename
            	]));
        
    }

}