<?php

namespace App\Http\Regions;

class HeaderNavbar
{
    protected function prepareLinks()
    {
        $user = request()->user();

        return collect(config('menu.header'))
            ->map(function ($value, $key) {
                return [
                    'title' => trans("menu.header.$key"),
                    'route' => $value['route'],
                ];
            })
            ->putWhen(! $user, 'user', [
                'title' => trans('menu2.header.user'),
                'route' => route('login.form'),
                'menu' => true,
            ])
            ->putWhen($user, 'user', [
                'title' => $user ? $user->name : '',
                'route' => route('user.show', [$user]),
                'badge' => $user ? $user->unreadMessagesCount() : '',
                'menu' => true,
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
                'route' => route('user.show', [$user]),
            ])
            ->pushWhen($user, [
                'title' => trans('menu.user.edit.profile'),
                'route' => route('user.edit', [$user]),
            ])
            ->pushWhen($user, [
                'title' => trans('menu.user.message'),
                'route' => route('message.index', [$user]),
                'badge' => $user ? $user->unreadMessagesCount() : '',
            ])
            ->pushWhen($user && $user->hasRole('admin'), [
                'title' => trans('menu.auth.admin'),
                'route' => route('content.index', ['internal']),
            ])
            ->pushWhen($user, [
                'title' => trans('menu.auth.logout'),
                'route' => route('login.logout'),
            ])
            ->toArray();
    }

    public function render()
    {
        return collect()
            ->push(component('HeaderNavbar')
                ->with('links', $this->prepareLinks())
                ->with('sublinks', $this->prepareSublinks())
                ->render()
            )
            ->implode('');
    }
}
