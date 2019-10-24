<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class ComponentController extends Controller
{
    public function components()
    {
        return collect(
            Storage::disk('resources')->directories('/views/components')
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
            '/views/components/' . $c . '/' . $c . '.blade.php'
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
            ($this->isBladeComponent($c) ? 'blade   ' : '        ') .
            ($this->isVueComponent($c) ? '   vue' : '      ') .
            ($this->isCss($c) ? '   css' : '      ');
    }

    public function index()
    {
        return layout('Two')
            ->with(
                'content',
                collect()
                    ->pushWhen(!request()->has('c'),
                        component('Title')
                            ->is('large')
                            ->with('title', 'Components')
                    )
                    ->pushWhen(
                        !request()->has('list') && !request()->has('c'),
                        component('Link')
                            ->with('title', 'Show list')
                            ->with('route', route('components', ['list']))
                    )
                    ->pushWhen(
                        request()->has('list') && !request()->has('c'),
                        component('Link')
                            ->with('title', 'Show previews')
                            ->with('route', route('components'))
                    )
                    ->merge(
                        $this->components()
                            ->filter(function ($c) {
                                if (request()->has('c')) {
                                    return $c == request()->get('c');
                                }
                                return !starts_with($c, 'Aff');
                            })
                            ->map(function ($c) {
                                return collect()
                                    ->pushWhen(!request()->has('c'),
                                        component('Code')
                                            ->is('gray')
                                            ->with(
                                                'route',
                                                route('components', ['c' => $c])
                                            )
                                            ->with(
                                                'code',
                                                $this->componentCode($c)
                                            )
                                    )
                                    ->pushWhen(
                                        !request()->has('list') ||
                                            request()->has('c'),
                                        component($c)->with('title', $c)
                                    )
                                    ->pushWhen(
                                        !request()->has('list'),
                                        component($c)
                                            ->with('title', $c)
                                            ->vue()
                                    );
                            })
                    )
                    ->flatten()
            )
            ->render();
    }
}
