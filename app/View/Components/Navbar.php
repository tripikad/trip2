<?php

namespace App\View\Components;

use App\User;
use Illuminate\View\Component;
use Illuminate\View\View;

class Navbar extends Component
{
    public ?User $user;
    public string $type;
    public array $menuLinks = [];
    public array $userLinks = [];

    private function getMenuLinks()
    {
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
            ->put('travel_offer', [
                'title' => trans('Reisipakkumised'),
                'route' => route('travel_offer.index'),
                'new' => trans('menu.header.new'),
            ])
            // @LAUNCH Remove this check
            /*->putWhen($user && $user->hasRole('superuser'), 'offer', [
                'title' => trans('menu.header.offer'),
                'new' => trans('menu.header.new'),
                'route' => route('offer.index')
            ])*/
            ->toArray();
    }

    private function getUserLinks()
    {
        $user = $this->user;

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
                        'route' => route('company.profile.public', ['slug' => $user->company->slug])
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
                    ->push([
                        'title' => trans('menu.auth.logout'),
                        'route' => route('login.logout')
                    ])
                    ->toArray();
            }
        }
    }

    /**
     * Create a new component instance.
     *
     * @param string $type
     */
    public function __construct(string $type = 'dark')
    {
        $this->user = auth()->user();
        $this->type = $type;
        $this->menuLinks = $this->getMenuLinks();
        $this->userLinks = $this->getUserLinks();

        if ($this->user) {
            $this->user->unreadMessages = $this->user->unreadMessagesCount();
            $this->user->image = $this->user->imagePreset('xsmall_square');
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        $title = trans('menu.header.my');
        $route = route('login.form');

        return view('components.Navbar', [
            'title' => $title,
            'route' => $route,
            'svg' => $this->type === 'dark' ? '#tripee_logo_dark' : '#tripee_logo'
        ]);
    }
}