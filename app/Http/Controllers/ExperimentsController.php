<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class ExperimentsController extends Controller
{
    private function files()
    {
        return collect(Storage::disk('resources')->files('/views/svg'))->map(
            function ($file) {
                return str_limit(
                    file_get_contents(Storage::disk('resources')->path($file)),
                    200
                );
                //return file_get_contents($file);
            }
        );
    }

    private function components()
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
                            ->with(
                                'code',
                                $file . "\n\n" . $this->files()[$index]
                            )
                    )
                    ->merge(
                        collect(['sm', 'md', 'lg', 'xl', ''])->map(function (
                            $size
                        ) use ($file) {
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

    public function index()
    {
        return layout('Two')
            ->with(
                'content',
                collect()
                    // ->push(
                    //     component('Code')
                    //         ->is('gray')
                    //         ->with('code', '{ sm: 14, md: 18, lg: 26, xl: 36 }')
                    // )
                    // ->merge($this->components())
                    ->push(
                        component('Buttons')->with('items', ['hello', 'world'])
                    )
            )
            ->render();
    }
}
