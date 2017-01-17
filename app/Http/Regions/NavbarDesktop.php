<?php

namespace App\Http\Regions;

class NavbarDesktop
{
    protected function prepareLinks()
    {
        $user = request()->user();

        return collect()
            ->put('oldtrip', [
                'title' => trans('menu.header.oldtrip'),
                'route' => route('frontpage.index'),
            ])
            ->put('flight', [
                'title' => trans('menu.header.flights'),
                'route' => route('v2.flight.index'),
            ])
            ->put('travelmate', [
                'title' => trans('menu.header.travelmates'),
                'route' => route('v2.travelmate.index'),
            ])
            ->put('forum', [
                'title' => trans('menu.header.forum'),
                'route' => route('v2.forum.index'),
            ])
            ->put('news', [
                'title' => trans('menu.header.news'),
                'route' => route('v2.news.index'),
            ])
            ->toArray();
    }

    protected function prepareSublinks()
    {
        $user = request()->user();

        return collect()
            ->pushWhen(! $user, [
                'title' => trans('menu.auth.login'),
                'route' => route('login.form'),
            ])
            ->pushWhen(! $user, [
                'title' => trans('menu.auth.register'),
                'route' => route('register.form'),
            ])
            ->pushWhen($user, [
                'title' => trans('menu.user.profile'),
                'route' => route('v2.user.show', [$user]),
            ])
            ->pushWhen($user, [
                'title' => trans('menu.user.edit.profile'),
                'route' => route('user.edit', [$user]),
            ])
            ->pushWhen($user, [
                'title' => trans('menu.user.message'),
                'route' => route('v2.message.index', [$user]),
                'badge' => $user ? $user->unreadMessagesCount() : '',
            ])
            ->pushWhen($user && $user->hasRole('admin'), [
                'title' => trans('menu.auth.admin'),
                'route' => route('v2.internal.index'),
            ])
            ->pushWhen($user, [
                'title' => trans('menu.auth.logout'),
                'route' => route('login.logout'),
            ])
            ->toArray();
    }

    public function render($color = '')
    {
        $user = request()->user();

        return collect()
            ->push(component('NavbarDesktop')
                ->is($color)
                ->with('links', $this->prepareLinks())
                ->with('sublinks', $this->prepareSublinks())
                ->with('title', trans('menu.header.my'))
                ->with('route', route('login.form'))
                ->with('user', $user ? collect()
                    ->put('title', $user->vars()->name)
                    ->put('image', $user->imagePreset('small_square'))
                    ->put('badge', $user->unreadMessagesCount())
                    ->put('rank', $user->vars()->rank)
                : '')
                ->render()
            )
            ->implode('');
    }
}
