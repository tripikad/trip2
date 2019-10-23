<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class ComponentController extends Controller
{
    public function components()
    {
        return collect(
            Storage::disk('resources')->directories(
                '/views/components'
            )
        )->map(function ($dir) {
            return basename($dir);
        });
    }

    public function isVueComponent($c)
    {
        return Storage::disk('resources')->exists(
            '/views/components/' . $c . '/' . $c . '.vue'
        );
    }

    public function isBladeComponent($c)
    {
        return Storage::disk('resources')->exists(
            '/views/components/' .
                $c .
                '/' .
                $c .
                '.blade.php'
        );
    }

    public function index()
    {
        return layout('Two')
            ->with(
                'content',
                collect()
                    ->merge(
                        $this->components()
                            ->filter(function ($c) {
                                return !starts_with(
                                    $c,
                                    'Aff'
                                );
                            })
                            // ->filter(function ($c) {
                            //     return !in_array($c, [
                            //         'DestinationFacts',
                            //         'ExperimentalGrid',
                            //         'Form',
                            //         'FormHorizontal',
                            //         'ForumRowSmall',
                            //         'Grid',
                            //         'Grid2',
                            //         'Grid3',
                            //         'Grid4',
                            //         'GridSplit',
                            //         'Header',
                            //         'HeaderLight',
                            //         'HeaderTab',
                            //         'HeaderTabs',
                            //         'NewsCard',
                            //         'Paginator'
                            //     ]);
                            // })
                            // ->slice(0, 20)
                            ->map(function ($c) {
                                return collect()->push(
                                    component('Code')->with(
                                        'code',
                                        str_pad(
                                            $c,
                                            30,
                                            ' '
                                        ) .
                                            ($this->isBladeComponent(
                                                $c
                                            )
                                                ? 'blade '
                                                : '        ') .
                                            ($this->isVueComponent(
                                                $c
                                            )
                                                ? '   vue'
                                                : '      ')
                                    )
                                );
                            })
                    )
                    ->flatten()
            )
            ->with('sidebar', ['&nbsp;'])
            ->render();
    }
}
