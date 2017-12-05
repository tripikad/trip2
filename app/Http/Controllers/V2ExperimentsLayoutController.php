<?php

namespace App\Http\Controllers;

class V2ExperimentsLayoutController extends Controller
{
    public function indexOne()
    {
        return layout('One')

            ->with('color', 'gray')

            ->with('background', component('BackgroundMap'))

            ->with('header', region('StaticHeader'))

            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', trans('auth.login.title'))
                )
                ->push(component('Title')
                    ->is('center')
                    ->is('small')
                    ->with('title', trans('auth.login.not.registered', [
                        'link' => format_link(
                            route('register.form'),
                            trans('auth.login.not.registered.link.title')
                        ),
                    ]))
                )
            )

            ->with('content_top', component('Grid3')->with('items', collect()
                ->push(component('AuthTab')
                    ->with('title', trans('auth.login.field.name.title'))
                )
                ->push(component('AuthTab')
                    ->is('facebook')
                    ->with('route', route('facebook.redirect'))
                    ->with('title', 'Facebook')
                )
                ->push(component('AuthTab')
                    ->is('google')
                    ->with('route', route('google.redirect'))
                    ->with('title', 'Google')
                )
            ))

            ->with('content', collect()
                ->push(component('Placeholder')
                    ->with('title', 'Content1')
                )
                ->push(component('Placeholder')
                    ->with('title', 'Content2')
                )
            )

            ->with('bottom', collect()->push(component('MetaLink')
                ->with('title', trans('auth.login.forgot.password', [
                    'link' => format_link(
                        route('reset.apply.form'),
                        trans('auth.reset.apply.title.link')
                    ),
                ]))
            ))

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function indexTwo()
    {
        return layout('Two')

            ->with('background', component('BackgroundMap'))

            ->with('color', 'gray')

            ->with('header', region('StaticHeader', collect()
                ->push(component('Title')->with('title', 'Header'))
            ))

            ->with('content', collect()
                ->push(component('Placeholder')
                    ->is('large')
                    ->with('title', 'Content1')
                )
                //->push(component('Promo')->with('promo', 'body'))
                ->push(component('PlaceholderPromo')
                    ->is('body')
                    ->with('title', 'AD')
                )
                ->push(component('Placeholder')
                    ->is('large')
                    ->with('title', 'Content2')
                )
            )

            ->with('sidebar', collect()
                ->push(region('FlightAbout'))
                //->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('PlaceholderPromo')->with('title', 'AD'))
                //->push(component('Promo')->with('promo', 'sidebar_large'))
                ->push(component('Placeholder')
                    ->with('title', 'Sidebar1')
                )
                ->push(component('PlaceholderPromo')
                    ->is('large')
                    ->with('title', 'AD')
                )
                ->push(component('Placeholder')
                    ->with('title', 'Sidebar2')
                )
            )

            ->with('bottom', collect()
                ->push(component('Placeholder')->with('title', 'Bottom'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function indexFrontpage()
    {
        return layout('Frontpage2')

            ->with('header', region('FrontpageHeader', collect()))

            ->with('top', collect()
                ->push(component('Placeholder')
                    ->with('title', 'Top')
                )
                ->push(component('BlockHorizontal')
                    ->is('center')
                    ->with('content', collect()->push(component('Link')
                        ->is('blue')
                        ->with('title', trans('frontpage.index.all.offers'))
                        ->with('route', route('flight.index'))
                    ))
                )
                ->push(region('FrontpageAbout'))
            )

            ->with('content', collect()
                ->push(component('Placeholder')
                    ->with('title', 'Content1')
                )
                ->push(component('Placeholder')
                    ->is('ad')
                    ->with('title', 'Ad')
                )
                // ->push(component('Promo')->with('promo', 'body'))
                ->push(component('Placeholder')
                    ->with('title', 'Content2')
                )
            )

            ->with('sidebar', collect()
                ->push(component('Placeholder')
                    ->with('title', 'Content2')
                )
                //->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Placeholder')
                    ->is('ad')
                    ->with('title', 'Ad')
                )
                ->push(component('Placeholder')
                    ->with('title', 'Sidebar2')
                )
                //->push(component('Promo')->with('promo', 'sidebar_large'))
                ->push(component('Placeholder')
                    ->is('ad')
                    ->with('title', 'Ad')
                )
            )

            ->with('bottom1', collect()
                ->push(component('Placeholder')
                    ->with('title', 'Bottom1.1')
                )
                ->push(component('Placeholder')
                    ->with('title', 'Bottom1.2')
                )
            )

            ->with('bottom2', collect()
                ->push(component('Placeholder')
                    ->with('title', 'Bottom2')
                )
            )

            ->with('bottom3', collect()
                ->push(component('Placeholder')
                    ->with('title', 'Bottom3.1')
                )
                ->push(component('Placeholder')
                    ->with('title', 'Bottom3.2')
                )
            )

            ->with('footer', region('Footer'))

            ->render();
    }
}
