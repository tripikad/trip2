<?php

namespace App\Http\Controllers\Styleguide;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Content;

class IconsController extends Controller
{
    public function index()
    {
        $photos = Content::getLatestItems('photo', 6);

        return layout('Two')
            ->with('title', 'Styles')
            ->with(
                'content',
                collect()
                    ->push(region('StyleguideMenu'))
                    ->push(component('Title')->with('title', 'Icons'))
                    ->push(
                        component('Code')
                            ->is('gray')
                            ->with('code', '{ sm: 14, md: 18, lg: 26, xl: 36 }')
                    )
                    ->merge($this->svgComponents())
            )
            ->render();
    }

    private function svgFiles()
    {
        return collect(Storage::disk('resources')->files('/views/svg'))->map(function ($file) {
            return str_limit(file_get_contents(Storage::disk('resources')->path($file)), 200);
        });
    }

    private function svgComponents()
    {
        return collect(Storage::disk('resources')->files('/views/svg'))
            ->map(function ($file) {
                return str_replace(['.svg'], '', basename($file));
            })
            ->map(function ($file, $index) {
                return collect()
                    ->push(
                        component('Code')
                            ->is('gray')
                            ->with('code', $file . "\n\n" . $this->svgFiles()[$index])
                    )
                    ->merge(
                        collect(['sm', 'md', 'lg', 'xl'])->map(function ($size) use ($file) {
                            return '<div class="StyleIcon">' .
                                component('Icon')
                                    ->with('size', $size)
                                    ->with('icon', $file)
                                    ->render() .
                                '</div>';
                        })
                    )
                    ->flatten();
            })
            ->flatten()
            ->push(component('StyleIcon'));
    }
}
