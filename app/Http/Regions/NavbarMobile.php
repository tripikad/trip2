<?php

namespace App\Http\Regions;

class NavbarMobile
{
    protected function prepareLinks()
    {
        $user = request()->user();

        return collect()
            ->push([
                'title' => trans('menu.header.home'),
                'route' => route('frontpage.index'),
            ])
            ->push([
                'title' => trans('menu.header.flights'),
                'route' => route('flight.index'),
            ])
            ->push([
                'title' => trans('menu.header.travelmates'),
                'route' => route('travelmate.index'),
            ])
            ->push([
                'title' => trans('menu.header.forum'),
                'route' => route('forum.index'),
            ])
            ->push([
                'title' => trans('menu.header.news'),
                'route' => route('news.index'),
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
                'title' => trans('menu.header.user'),
                'route' => route('user.show', [$user]),
            ])
            ->pushWhen($user, [
                'title' => trans('menu.header.edit'),
                'route' => route('user.edit', [$user]),
            ])
            ->pushWhen($user, [
                'title' => trans('menu.user.message'),
                'route' => route('message.index', [$user]),
                'badge' => $user ? $user->unreadMessagesCount() : '',
            ])
            ->pushWhen($user && $user->hasRole('admin'), [
                'title' => trans('menu.auth.admin'),
                'route' => route('internal.index'),
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
            ->push(component('NavbarMobile')
                ->is($color)
                ->with('links', $this->prepareLinks())
                ->with('sublinks', $this->prepareSublinks())
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
