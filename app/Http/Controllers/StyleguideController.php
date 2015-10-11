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
                $header = preg_split('/\n\n/', str_replace('{{--', '', $parts[0]));
                $components[] = [
                    'title' => basename($filepath),
                    'description' => $header[1],
                    'code' => $header[2],
                    'rendered_code' => StringView::make([
                        'template' => $header[2],
                        'cache_key' => $filepath,
                        'updated_at' => 0
                    ])
                ];
            }

        }

        return view('pages.styleguide.index', ['components' => $components]);
        
    }

}