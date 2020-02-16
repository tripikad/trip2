<?php

namespace App\Http\Controllers\Styleguide;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ComponentsController extends Controller
{
    public function index()
    {
        return layout('Two')
            ->with('title', 'Components')
            ->with(
                'content',
                collect()
                    ->push(region('StyleguideMenu'))
                    ->push(component('Title')->with('title', 'Components'))
                    ->merge(
                        $this->components()
                            ->filter(function ($c) {
                                return !starts_with($c, 'Aff');
                            })
                            ->map(function ($c) {
                                return collect()
                                    ->push(
                                        component('Code')
                                            ->is('gray')
                                            ->with('code', $this->componentCode($c))
                                    )
                                    ->pushWhen(request()->has('preview'), component($c)->with('title', $c))
                                    ->pushWhen(
                                        request()->has('preview'),
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

    public function components()
    {
        return collect(Storage::disk('resources')->directories('/views/components'))->map(function ($dir) {
            return basename($dir);
        });
    }

    public function isVueComponent($c)
    {
        return Storage::disk('resources')->exists('/views/components/' . $c . '/' . $c . '.vue');
    }

    public function isBladeComponent($c)
    {
        return Storage::disk('resources')->exists('/views/components/' . $c . '/' . $c . '.blade.php');
    }

    public function isCss($c)
    {
        return Storage::disk('resources')->exists('/views/components/' . $c . '/' . $c . '.css');
    }

    public function componentCode($c)
    {
        return str_pad($c, 30, ' ') .
            ($this->isBladeComponent($c) ? 'blade   ' : '        ') .
            ($this->isVueComponent($c) ? '   vue' : '      ') .
            ($this->isCss($c) ? '   css' : '      ');
    }
}
