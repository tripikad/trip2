<?php

namespace App\Http\Regions;

use Illuminate\Http\Request;
use Carbon\Carbon;

class Footer
{

    protected function prepareLinks($menuKey)
    {
        return collect(config("menu.$menuKey"))
            ->map(function ($value, $key) use ($menuKey) {
                return (object) [
                    'title' => trans("menu.$menuKey.$key"),
                    'route' => $value['route'],
                    'icon' => isset($value['icon'])
                        ? component('Icon')->is('white')->with('icon', $value['icon'])
                        : '',
                    'target' => isset($value['external']) ? '_blank' : '',
                ];
            });
    }

    public function render(Request $request)
    {
        return component('Footer')
            ->with('image', '/photos/footer.jpg')
            ->with('logo_route', route('frontpage.index'))
            ->with('logo', component('Icon')
                ->is('white')
                ->with('icon', 'tripee_logo_plain')
                ->with('width', '100')
                ->with('height', '25')
                ->with('color', 'white')
            )
            ->with('links', [
                'col1' => $this->prepareLinks('footer'),
                'col2' => $this->prepareLinks('footer2'),
                'col3' => $this->prepareLinks('footer3'),
                'social' => $this->prepareLinks('footer-social'),
            ])
            ->with('licence', trans('site.footer.copyright', [
                'current_year' => Carbon::now()->year,
            ]));
    }
}
