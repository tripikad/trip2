<?php

namespace App\Http\Regions;

use Carbon\Carbon;

class Footer
{
    protected function prepareCol1Links()
    {
        return collect()
            ->push([
                'title' => trans('menu.footer.flights'),
                'route' => route('v2.flight.index'),
            ])
            ->push([
                'title' => trans('menu.footer.travelmates'),
                'route' => route('v2.travelmate.index'),
            ])
            ->push([
                'title' => trans('menu.footer.news'),
                'route' => route('v2.news.index'),
            ])
            ->push([
                'title' => trans('menu.footer.blogs'),
                'route' => route('v2.blog.index'),
            ])
            ->push([
                'title' => trans('menu.footer.photos'),
                'route' => route('v2.photo.index'),
            ])
            ->map(function ($item) {
                return (object) $item;
            });
    }

    protected function prepareCol2Links()
    {
        return collect()
            ->push([
                'title' => trans('menu.footer2.forum'),
                'route' => route('v2.forum.index'),
            ])
            ->push([
                'title' => trans('menu.footer2.buysell'),
                'route' => route('v2.buysell.index'),
            ])
            ->push([
                'title' => trans('menu.footer2.expat'),
                'route' => route('v2.expat.index'),
            ])
            ->map(function ($item) {
                return (object) $item;
            });
    }

    protected function prepareCol3Links()
    {
        $loggedUser = request()->user();

        return collect()
            ->push([
                'title' => trans('menu.footer3.about'),
                'route' => route('v2.static.show', [1534]),
            ])
            ->push([
                'title' => trans('menu.footer3.contact'),
                'route' => route('v2.static.show', [972]),
            ])
            ->push([
                'title' => trans('menu.footer3.eula'),
                'route' => route('v2.static.show', [25151]),
            ])
            ->push([
                'title' => trans('menu.footer3.advertising'),
                'route' => route('v2.static.show', [22125]),
            ])
            ->pushWhen(!$loggedUser, [
                'title' => trans('menu.auth.login'),
                'route' => route('login.form'),
            ])
            ->pushWhen(!$loggedUser, [
                'title' => trans('menu.auth.register'),
                'route' => route('register.form'),
            ])
            ->pushWhen($loggedUser, [
                'title' => trans('menu.auth.logout'),
                'route' => route('login.logout'),
            ])
            ->map(function ($item) {
                return (object) $item;
            });
    }

    protected function prepareSocialLinks()
    {
        return collect(config('menu.footer-social'))
            ->map(function ($value, $key) {
                return (object) [
                    'title' => trans("menu.footer-social.$key"),
                    'route' => $value['route'],
                    'icon' => isset($value['icon'])
                        ? component('Icon')->is('white')->with('icon', $value['icon'])
                        : '',
                    'target' => isset($value['external']) ? '_blank' : '',
                ];
            });
    }

    public function render()
    {
        return component('Footer')
            ->with('image', '/photos/footer.jpg')
            ->with('logo_route', route('v2.frontpage.index'))
            ->with('logo', component('Icon')
                ->is('white')
                ->with('icon', 'tripee_logo_plain')
                ->with('width', '100')
                ->with('height', '25')
                ->with('color', 'white')
            )
            ->with('links', [
                'col1' => $this->prepareCol1Links(),
                'col2' => $this->prepareCol2Links(),
                'col3' => $this->prepareCol3Links(),
                'social' => $this->prepareSocialLinks(),
            ])
            ->with('licence', trans('site.footer.copyright', [
                'current_year' => Carbon::now()->year,
            ]));
    }
}
