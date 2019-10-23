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

    public function isCss($c)
    {
        return Storage::disk('resources')->exists(
            '/views/components/' . $c . '/' . $c . '.css'
        );
    }

    public function componentCode($c)
    {
        return str_pad($c, 30, ' ') .
            ($this->isBladeComponent($c)
                ? 'blade   '
                : '        ') .
            ($this->isVueComponent($c)
                ? '   vue'
                : '      ') .
            ($this->isCss($c) ? '   css' : '      ');
    }

    public function isFiltered($c)
    {
        return in_array($c, [
            //'DestinationFacts',
            //'ExperimentalGrid',
            //'Form',
            //'FormHorizontal',
            //'ForumRowSmall',
            //'Grid',
            //'Grid2',
            //'Grid3',
            //'Grid4',
            //'GridSplit',
            //'Header',
            //'HeaderLight',
            //'HeaderTab',
            //'HeaderTabs',
            //'NewsCard',
            //'Paginator',
            //'PaginatorExtended',
            //'PhotoResponsive',
            //'PhotoRow'
        ]);
    }

    public function index()
    {
        return layout('Two')
            ->with(
                'content',
                collect()
                    ->push(
                        component('Title')
                            ->is('large')
                            ->with('title', 'Components')
                    )
                    ->merge(
                        $this->components()
                            ->filter(function ($c) {
                                return !starts_with(
                                    $c,
                                    'Aff'
                                );
                            })
                            ->map(function ($c) {
                                return collect()
                                    ->push('&nbsp;')
                                    ->push(
                                        component('Code')
                                            ->is('gray')
                                            ->with(
                                                'code',
                                                $this->componentCode(
                                                    $c
                                                )
                                            )
                                    )
                                    ->pushWhen(
                                        !$this->isFiltered(
                                            $c
                                        ),
                                        component($c)
                                            ->with(
                                                'title',
                                                $c
                                            )
                                            // ->with(
                                            //     'content',
                                            //     $c
                                            // )
                                            // ->with(
                                            //     'items',
                                            //     []
                                            // )
                                            // ->with(
                                            //     'facts',
                                            //     []
                                            // )
                                            // ->with(
                                            //     'fields',
                                            //     []
                                            // )
                                            // ->with(
                                            //     'meta',
                                            //     ''
                                            // )
                                            // ->with(
                                            //     'left_content',
                                            //     []
                                            // )
                                            // ->with(
                                            //     'right_content',
                                            //     []
                                            // )
                                            
                                            
                                    )
                                    ->pushWhen(
                                        !$this->isFiltered(
                                            $c
                                        ),
                                        component($c)
                                            ->with(
                                                'title',
                                                $c
                                            )
                                            ->with(
                                                'content',
                                                ''
                                            )
                                            ->vue()
                                            
                                    );
                            })
                    )
                    ->flatten()
            )
            ->render();
    }
}
