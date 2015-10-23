<?php

namespace App\Http\Controllers;

use Symfony\Component\Yaml\Yaml;
use Storage;

class StyleguideController extends Controller
{
    public function index()
    {
        $components = [];

        $directories = array_merge(
            ['views/component'],
            Storage::disk('resources')->allDirectories('views/component'),
            ['assets/sass/base']
        );

        foreach ($directories as $directory) {
            foreach (Storage::disk('resources')->files($directory) as $filepath) {
                if ($header = $this->getHeader($filepath)) {
                    $components[] = ['title' => $filepath] + $header;
                }
            }
        }

        return view('pages.styleguide.index', [
            'components' => $components,
            'icons' => $this->getIcons(),
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

        // Get the file contents

        $file = Storage::disk('resources')->get($filepath);

        // Split the file to the header and body

        $parts = preg_split($end, $file);

        // Verify we have the header

        if (count($parts) > 1) {
            $header = Yaml::parse(trim(preg_replace($start, '', $parts[0])));

            return [
                'description' => isset($header['description']) ? trim($header['description']) : null,
                'code' => isset($header['code']) ? trim($header['code']) : null,
                'options' => isset($header['options']) ? array_merge(['(none)'], $header['options']) : null,
            ];
        }

        return false;
    }

    public function getIcons()
    {
        $icons = [];

        foreach (Storage::disk('resources')->files('assets/svg/sprite') as $filepath) {
            $icons[] = pathinfo($filepath)['filename'];
        }

        return $icons;
    }
}
