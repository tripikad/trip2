<?php

namespace App\Http\Controllers;

use App\Content;

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

            ->with('top', collect()->push(
                component('HeaderUnpublished')
                    ->with('title', trans('Top'))
            ))

            ->with('content', collect()
                ->push(component('Placeholder')
                    ->is('xl')
                    ->with('title', 'Content1')
                )
                //->push(component('Promo')->with('promo', 'body'))
                ->push(component('PlaceholderPromo')
                    ->is('sm')
                    ->with('title', 'BODY')
                )
                ->push(component('Placeholder')
                    ->is('xl')
                    ->with('title', 'Content2')
                )
            )

            ->with('sidebar_top', collect()
                ->push(region('FlightAbout'))
                ->push(component('PlaceholderPromo')
                    ->with('title', 'SIDEBAR_SMALL')
                )
            )

            ->with('sidebar', collect()
                ->push(component('Placeholder')
                    ->is('lg')
                    ->with('title', 'Sidebar1')
                )
                ->push(component('PlaceholderPromo')
                    ->is('xl')
                    ->with('title', 'SIDEBAR_LARGE')
                )
                ->push(component('Placeholder')
                    ->is('lg')
                    ->with('title', 'Sidebar2')
                )
            )

            ->with('bottom', collect()
                ->push(component('Placeholder')->with('title', 'Bottom'))
                ->push(component('PlaceholderPromo')
                    ->is('lg')
                    ->with('title', 'FOOTER')
                )
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function indexFrontpage()
    {
        $flights = Content::getLatestItems('flight', 4);
        $forums = Content::getLatestItems('forum', 4);
        $buysells = Content::getLatestItems('buysell', 4);
        $expats = Content::getLatestItems('expat', 4);
        $miscs = Content::getLatestItems('misc', 4);
        $news = Content::getLatestItems('news', 4);

        return layout('Frontpage2')

            ->with('header', region('FrontpageHeader', collect()))

            ->with('top', collect()
                ->push(component('ExperimentGrid')
                    ->with('items', $flights->map(function ($flight, $index) {
                        return region(
                            'DestinationBar',
                            $flight->destinations()->first(),
                            ['purple', 'yellow', 'red', 'orange'][$index]
                        ).
                        region('FlightCard', $flight);
                    }))
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
                    ->is('xl')
                    ->with('title', 'Content1')
                )
                ->push(component('PlaceholderPromo')
                    ->is('sm')
                    ->with('title', 'BODY')
                )
                ->push(component('Placeholder')
                    ->is('xl')
                    ->with('title', 'Content2')
                )
            )

            ->with('sidebar', collect()
                ->push(component('Placeholder')
                    ->is('lg')
                    ->with('title', 'Content2')
                )
                ->push(component('PlaceholderPromo')
                    ->with('title', 'SIDEBAR_SMALL')
                )
                ->push(component('Placeholder')
                    ->is('lg')
                    ->with('title', 'Sidebar2')
                )
                ->push(component('PlaceholderPromo')
                    ->is('xl')
                    ->with('title', 'SIDEBAR_LARGE')
                )
            )

            ->with('content', collect())
            ->with('sidebar', collect())

            ->with('bottom0', collect()
                ->push(component('ExperimentGrid')
                    ->with('rows', '20% 40% 40%')
                    ->with('gap', '4')
                    ->with('items', collect()
                        ->push(collect()
                            ->push(component('Title')
                                ->is('gray')
                                ->with('title', 'Foorum')
                            )
                            ->push('&nbsp;')
                            ->push(component('Body')
                                ->is('gray')
                                ->with('body', 'Eesti suurim reisifoorum. Küsi siin oma küsimus või jaga häid soovitusi. Eesti suurim reisifoorum. Küsi siin oma küsimus või jaga häid soovitusi.')
                            )
                            ->push('&nbsp;')
                            ->push(component('PlaceholderPromo')
                                ->with('title', 'SIDEBAR_SMALL')
                            )
                            ->render()
                            ->implode('')
                        )
                        ->push(component('Block')
                            ->with('title', trans('General forum'))
                            ->with('content', $forums->map(function ($forum) {
                                return region('ForumRow', $forum);
                            }))
                        )
                        ->push(component('Block')
                            ->with('title', trans('Buysell'))
                            ->with('content', $buysells->map(function ($buysell) {
                                return region('ForumRow', $buysell);
                            }))
                        )
                        ->push('')
                        ->push(component('Block')
                            ->with('title', trans('Expat'))
                            ->with('content', $expats->map(function ($expat) {
                                return region('ForumRow', $expat);
                            }))
                        )
                        ->push(component('Block')
                            ->with('title', trans('Misc'))
                            ->with('content', $miscs->map(function ($misc) {
                                return region('ForumRow', $misc);
                            }))
                        )
                    )
                )
            )

            ->with('bottom1', collect()
                ->push(component('ExperimentGrid')
                    ->with('gap', '2')
                    ->with('items', $news->map(function ($new) {
                        return region('NewsCard', $new);
                    }))
                )
                ->push(component('Placeholder')
                    ->with('title', 'Bottom1, part 2')
                )
            )

            ->with('bottom2', collect()
                ->push(component('Placeholder')
                    ->with('title', 'Bottom2')
                )
            )

            ->with('bottom3', collect()
                ->push(component('Placeholder')
                    ->with('title', 'Bottom3, part 1')
                )
                ->push(component('Placeholder')
                    ->with('title', 'Bottom3, part 2')
                )
                ->push(component('PlaceholderPromo')
                    ->is('lg')
                    ->with('title', 'FOOTER')
                )
            )

            ->with('footer', region('Footer'))

            ->render();
    }
}
