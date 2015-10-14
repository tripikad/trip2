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

        $dirpaths = array_merge(
            ['views/component'], 
            Storage::disk('resources')->allDirectories('views/component')
        );

        foreach ($dirpaths as $dirpath) {

            foreach(Storage::disk('resources')->allFiles($dirpath) as $filepath) {

                $file = Storage::disk('resources')->get($filepath);
            
                $parts = preg_split('/--}/', $file);
                
                if (count($parts) > 1) {

                    $header = preg_split('/\n\n/', trim(str_replace('{{--', '', $parts[0])));
                    $components[] = [
                        'title' => $filepath,
                        'description' => trim($header[0]),
                        'code' => trim($header[1])
                    ];
                
                }

            }

        }

        return view('pages.styleguide.index', [
            'components' => $components,
            'icons' => $this->getIcons()
        ]);
        
    }

    public function getIcons()
    {

        $icons = [];

        foreach(Storage::disk('resources')->files('assets/svg/sprite') as $filepath) {

            $icons[] = pathinfo($filepath)['filename'];

        }

        return $icons;
        
    }

}