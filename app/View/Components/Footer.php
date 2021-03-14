<?php

namespace App\View\Components;

use App\User;
use Illuminate\View\Component;
use Illuminate\View\View;

class Footer extends Component
{
    private ?User $user;
    public string $type;

    /**
     * Create a new component instance.
     *
     * @param string $type
     */
    public function __construct($type = 'main')
    {
        $this->user = auth()->user();
        $this->type = $type;
    }

    protected function getCol1Links()
    {
        $user = $this->user;

        return collect()
            ->push([
                'title' => trans('menu.footer.flights'),
                'route' => route('flight.index')
            ])
            ->push([
                'title' => trans('menu.footer.travelmates'),
                'route' => route('travelmate.index')
            ])
            ->push([
                'title' => trans('menu.footer.news'),
                'route' => route('news.index')
            ])
            // @LAUNCH Remove this check
            ->pushWhen($user && $user->hasRole('superuser'), [
                'title' => trans('menu.footer.offer'),
                'route' => route('offer.index')
            ])
            ->push([
                'title' => trans('menu.footer.blogs'),
                'route' => route('blog.index')
            ])
            ->push([
                'title' => trans('menu.footer.photos'),
                'route' => route('photo.index')
            ])
            ->push([
                'title' => trans('menu.footer.destinations'),
                'route' => route('destination.index')
            ])
            ->toArray();
    }

    protected function getCol2Links()
    {
        return collect()
            ->push([
                'title' => trans('menu.footer2.forum'),
                'route' => route('forum.index')
            ])
            ->push([
                'title' => trans('menu.footer2.buysell'),
                'route' => route('buysell.index')
            ])
            ->push([
                'title' => trans('menu.footer2.expat'),
                'route' => route('expat.index')
            ])
            ->toArray();
    }

    protected function getCol3Links()
    {
        $user = $this->user;

        return collect()
            ->push([
                'title' => trans('menu.footer3.about'),
                'route' => route('static.show', 'tripist')
            ])
            ->push([
                'title' => trans('menu.footer3.contact'),
                'route' => route('static.show', 'kontakt')
            ])
            ->push([
                'title' => trans('menu.footer3.eula'),
                'route' => route('static.show', 'kasutustingimused')
            ])
            ->push([
                'title' => trans('menu.footer3.privacy'),
                'route' => route('static.show', 'privaatsustingimused')
            ])
            ->push([
                'title' => trans('menu.footer3.advertising'),
                'route' => route('static.show', 'reklaam')
            ])
            ->pushWhen(!$user, [
                'title' => trans('menu.auth.login'),
                'route' => route('login.form')
            ])
            ->pushWhen(!$user, [
                'title' => trans('menu.auth.register'),
                'route' => route('register.form')
            ])
            ->pushWhen($user, [
                'title' => trans('menu.auth.logout'),
                'route' => route('login.logout')
            ])
            ->toArray();
    }

    protected function getSocialLinks()
    {
        return collect()
            ->push([
                'title' => trans('menu.footer-social.facebook'),
                'route' => 'https://facebook.com/tripeeee',
                'icon' => 'icon-facebook',
            ])
            ->push([
                'title' => trans('menu.footer-social.twitter'),
                'route' => 'https://twitter.com/trip_ee',
                'icon' => 'icon-twitter'
            ])
            ->push([
                'title' => trans('menu.footer-social.flightfeed'),
                'route' => '/lendude_sooduspakkumised/rss',
                'icon' => 'icon-rss'
            ])
            ->push([
                'title' => trans('menu.footer-social.newsfeed'),
                'route' => '/index.atom',
                'icon' => 'icon-rss'
            ])
            ->toArray();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.Footer', [
            'links' => [
                'col1' => $this->getCol1Links(),
                'col2' => $this->getCol2Links(),
                'col3' => $this->getCol3Links(),
                'social' => $this->getSocialLinks()
            ]
        ]);
    }
}