<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class StyleguideController extends Controller
{

    public function index()
    {

        $components = [];

        foreach(Storage::disk('resources')->files('views/component') as $filepath) {

            $file = Storage::disk('resources')->get($filepath);
        
            $parts = preg_split('/--}/', $file);
            
            if (count($parts) > 1) {
                $header = preg_split('/\n\n/', str_replace('{{--', '', $parts[0]));
                $components[] = [
                    'title' => basename($filepath),
                    'description' => $header[1],
                    'code' => $header[2],
                ];
            }

        }

        return view('pages.styleguide.index', ['components' => $components]);
        
    }

}