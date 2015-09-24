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
        $v = Validator::make($request->all(), [
            'image' => 'required|image'
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        //save
        $cc = new ContentController();
        $filename = $cc->storeImage($request->file('image'), 'photo');
        Image::create(['filename' => $filename]);

        return redirect()
            ->route('admin.image.index')
            ->with('info', trans('image.uploaded', [
                    'imagename' => $filename
                ]));
        
    }

}