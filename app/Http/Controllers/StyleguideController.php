<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Storage;
use StringView;

class StyleguideController extends Controller
{

    public function index()
    {

        $components = [];

        foreach(Storage::disk('resources')->files('views/component') as $filepath) {

            $file = Storage::disk('resources')->get($filepath);
        
            $parts = preg_split('/--}/', $file);
            
            if (count($parts) > 1) {

                $header = preg_split('/\n\n/', trim(str_replace('{{--', '', $parts[0])));
                $components[] = [
                    'title' => basename($filepath),
                    'description' => trim($header[0]),
                    'code' => trim($header[1])
                ];
            
            }

        }

        return view('pages.styleguide.index', ['components' => $components]);
        
    }

}