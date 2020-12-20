<?php

namespace App\Http\Regions;

class NavbarDesktop
{
    protected function prepareLinks()
    {
        $user = auth()->user();

        return collect()
            ->put('flight', [
                'title' => trans('menu.header.flights'),
                'route' => route('flight.index')
            ])
            ->put('travelmate', [
                'title' => trans('menu.header.travelmates'),
                'route' => route('travelmate.index')
            ])
            ->put('forum', [
                'title' => trans('menu.header.forum'),
                'route' => route('forum.index')
            ])
            ->put('news', [
                'title' => trans('menu.header.news'),
                'route' => route('news.index')
            ])
            ->put('vacation_package', [
                'title' => trans('Puhkusepaketid'),
                'new' => trans('menu.header.new'),
                'route' => route('vacation_package.index')
            ])
            // @LAUNCH Remove this check
            ->putWhen($user && $user->hasRole('superuser'), 'offer', [
                'title' => trans('menu.header.offer'),
                'new' => trans('menu.header.new'),
                'route' => route('offer.index')
            ])
            ->toArray();
    }

    protected function prepareSublinks()
    {
        $user = auth()->user();

        if (!$user) {
            return collect()
                ->push([
                    'title' => trans('menu.auth.login'),
                    'route' => route('login.form')
                ])
                ->push([
                    'title' => trans('menu.auth.register'),
                    'route' => route('register.form')
                ])
                ->toArray();
        } else {

            if ($user->company) {
                return collect()
                    ->push([
                        'title' => trans('menu.user.profile'),
                        'route' => route('company.profile', [$user->company])
                    ])
                    ->push([
                        'title' => $user->company->name,
                        'route' => route('company.page', ['slug' => $user->company->slug])
                    ])
                    ->push([
                        'title' => trans('menu.auth.logout'),
                        'route' => route('login.logout')
                    ])->toArray();
            } else {
                return collect()
                    ->push([
                        'title' => trans('menu.user.profile'),
                        'route' => route('user.show', [$user])
                    ])
                    ->push([
                        'title' => trans('menu.user.edit.profile'),
                        'route' => route('user.edit', [$user])
                    ])
                    ->push([
                        'title' => trans('menu.user.message'),
                        'route' => route('message.index', [$user]),
                        'badge' => $user->unreadMessagesCount()
                    ])
                    ->pushWhen($user && $user->hasRole('admin'), [
                        'title' => trans('menu.auth.admin'),
                        'route' => route('internal.index')
                    ])
                    /** todo: make previous company -> is_company */
                    /*->pushWhen($user && $user->company, [
                        'title' => trans('menu.company.index'),
                        'route' => route('company.index')
                    ])*/
                    ->pushWhen($user && $user->hasRole('superuser'), [
                        'title' => trans('menu.company.admin.index'),
                        'route' => route('company.admin.index')
                    ])
                    ->push([
                        'title' => trans('menu.auth.logout'),
                        'route' => route('login.logout')
                    ])
                    ->toArray();
            }
        }
    }

    /*protected function prepareSublinks()
    {
        $user = auth()->user() ?? false;

        return collect()
            ->pushWhen(!$user, [
                'title' => trans('menu.auth.login'),
                'route' => route('login.form')
            ])
            ->pushWhen(!$user, [
                'title' => trans('menu.auth.register'),
                'route' => route('register.form')
            ])
            ->pushWhen($user, [
                'title' => trans('menu.user.profile'),
                'route' => $user ? route('user.show', [$user]) : null
            ])
            ->pushWhen($user, [
                'title' => trans('menu.user.edit.profile'),
                'route' => $user ? route('user.edit', [$user]) : null
            ])
            ->pushWhen($user, [
                'title' => trans('menu.user.message'),
                'route' => $user ? route('message.index', [$user]) : null,
                'badge' => $user ? $user->unreadMessagesCount() : ''
            ])
            ->pushWhen($user && $user->hasRole('admin'), [
                'title' => trans('menu.auth.admin'),
                'route' => route('internal.index')
            ])
            ->pushWhen($user && $user->is_company, [
                'title' => trans('menu.company.index'),
                'route' => route('company.index')
            ])
            ->pushWhen($user && $user->hasRole('superuser'), [
                'title' => trans('menu.company.admin.index'),
                'route' => route('company.admin.index')
            ])
            ->pushWhen($user, [
                'title' => trans('menu.auth.logout'),
                'route' => route('login.logout')
            ])
            ->toArray();
    }*/

    public function render($color = '')
    {
        $user = auth()->user();
        if ($user) {
            $user->unreadMessages = $user->unreadMessagesCount();
            $user->image = $user->imagePreset('xsmall_square');
        }

        return collect()
            ->push(
                component('NavbarDesktop')
                    ->is($color)
                    ->with('links', $this->prepareLinks())
                    ->with('sublinks', $this->prepareSublinks())
                    ->with('title', trans('menu.header.my'))
                    ->with('route', route('login.form'))
                    ->with('user', $user ?? null)

                    /*->with(
                        'user',
                        $user
                            ? collect()
                                ->put('title', $user->vars()->name)
                                ->put('image', $user->imagePreset('xsmall_square'))
                                ->put('unreadMessageCount', $user->unreadMessagesCount())
                                ->put('rank', $user->vars()->rank)
                            : ''
                    )*/
                    ->render()
            )
            ->implode('');
    }
}
