<?php

namespace App\Http\Controllers\Styleguide;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class StyleguideController extends Controller
{
    public function links()
    {
        return [
            [
                'short' => 'Overview',
                'title' => 'Overview',
                'route' => 'styleguide.index'
            ],
            [
                'short' => 'New component',
                'title' => 'Components',
                'route' => 'styleguide.creating'
            ],
            ['title' => 'Fonts', 'route' => 'styleguide.fonts'],
            ['title' => 'Grid', 'route' => 'styleguide.grid']
        ];
    }

    public function index()
    {
        return layout('Two')
            ->with('header', $this->header(true))
            ->with(
                'content',
                collect()
                    //->push(component('StyleLogo')->with('title', 'Cusco'))
                    ->push(
                        component('Body')
                            ->is('large')
                            ->with(
                                'body',
                                format_body(
                                    'Component library and CSS styleguide for Trip.ee. Shouldn\'t it be called a *design system*?'
                                )
                            )
                    )
                    ->merge(
                        collect($this->links())
                            ->withoutFirst()
                            ->map(function ($link) {
                                return component('Title')
                                    ->is('blue')
                                    ->with('title', $link['title'])
                                    ->with('route', route($link['route']));
                            })
                    )
            )
            ->with('footer', $this->footer())
            ->render();
    }

    public function creatingIndex()
    {
        return layout('Two')
            ->with('header', $this->header())
            ->with(
                'content',
                collect()
                    ->push(
                        component('Title')
                            ->is('large')
                            ->with('title', 'Creating a component')
                    )
                    ->push($this->mdfile('creating'))
            )
            ->with('footer', $this->footer())
            ->render();
    }

    public function header($front = false)
    {
        return component('HeaderLight')
            ->with(
                'navbar',
                component('Navbar')->with(
                    'logo',
                    component('Icon')
                        ->with('icon', 'tripee_logo_dark')
                        ->with('width', 200)
                        ->with('height', 150)
                )
            )
            ->with(
                'content',
                collect()
                    ->push(
                        component('StyleHeader')
                            ->is($front ? 'large' : '')
                            ->with('title', 'Cus&#8203;co')
                            ->with('route', route('styleguide.index'))
                    )
                    ->pushWhen(
                        !$front,
                        component('ExperimentalRow')
                            ->with('gap', 2)
                            ->with(
                                'items',
                                collect($this->links())->map(function ($link) {
                                    return component('Title')
                                        ->is('blue')
                                        ->is('small')

                                        ->with('title', $link['title'])
                                        ->with('route', route($link['route']));
                                })
                            )
                    )
            );
    }
    public function footer()
    {
        return component('StyleFooter')
            ->with('title', 'C')
            ->with('route', route('styleguide.index'))
            ->with(
                'licence',
                trans('site.footer.copyright', [
                    'current_year' => Carbon::now()->year
                ])
            );
    }

    public function mdfile($filename)
    {
        return $this->md(
            file_get_contents(
                Storage::disk('resources')->path(
                    '/views/md/' . $filename . '.md'
                )
            )
        );
    }

    public function md($md)
    {
        return component('Body')->with('body', format_body($md));
    }
}
