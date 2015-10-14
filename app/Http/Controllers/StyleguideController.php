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

        $dirpaths = ['views/component'] +  Storage::disk('resources')->allDirectories('views/component');

        foreach ($dirpaths as $dirpath) {

            foreach(Storage::disk('resources')->allFiles($dirpath) as $filepath) {
                
                $start = '/{{--/';
                $end = '/--}}/';

                if (pathinfo($filepath)['extension'] == 'scss') {
                    $start = '/\/*/';
                    $end = '/*\//';
                }

                if ($header = $this->getHeader($filepath, $start, $end)) {

                    $components[] = ['title' => $filepath] + $header;

                }
                
            }

        }

        return view('pages.styleguide.index', [
            'components' => $components,
            'icons' => $this->getIcons()
        ]);
        
    }

    public function getHeader($filepath, $start, $end)
    {

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