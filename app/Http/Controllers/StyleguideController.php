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

        $directories = array_merge(
            ['views/component'],
            Storage::disk('resources')->allDirectories('views/component'),
            ['assets/sass/style']
        );

        foreach ($directories as $directory) {

            foreach(Storage::disk('resources')->files($directory) as $filepath) {

                if ($header = $this->getHeader($filepath)) {

                    $components[] = ['title' => $filepath] + $header;

                }
                
            }

        }

        return view('pages.styleguide.index', [
            'components' => $components,
            'icons' => $this->getIcons()
        ]);
        
    }

    public function getHeader($filepath)
    {

        $start = '/{{--/';
        $end = '/--}}/';

        if (pathinfo($filepath)['extension'] == 'scss') {
                
            $start = '/\/\*/';
            $end = '/\*\//';
                
        }

        $file = Storage::disk('resources')->get($filepath);
        $parts = preg_split($end, $file);
     
        if (count($parts) > 1) {

            $header = preg_split('/\n\n/', trim(preg_replace($start, '', $parts[0])));
            
            return [
                'description' => trim($header[0]),
                'code' => trim($header[1])
            ];
        
        }
    
        return false;

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