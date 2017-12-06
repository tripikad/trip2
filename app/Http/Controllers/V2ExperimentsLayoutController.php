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
        $news = Content::getLatestItems('news', 7);
        $photos = Content::getLatestItems('photo', 9);

        return layout('Frontpage2')

            ->with('header', region('FrontpageHeader', collect()))

            ->with('top', collect()
                ->push(component('ExperimentGrid')
                    ->with('items', $flights->take(3)->map(function ($flight, $index) {
                        return region(
                            'DestinationBar',
                            $flight->destinations()->first(),
                            ['purple', 'yellow', 'red', 'orange'][$index]
                        )
                        .component('ExperimentCard')
                            ->is('center')
                            ->with('opacity', 0.5)
                            ->with('height', 18)
                            ->with('background', $flight->imagePreset('medium'))
                            ->with('title', $flight->vars()->title)
                        ;
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
                ->push(component('Dotmap')
                    ->with('dots', config('dots'))
                    ->with('opacity',0.3)
                    ->with('width', 500)
                )
                ->push(component('Title')
                    ->is('small')
                    ->is('gray')
                    ->with('title', 'Trip.ee on Eesti vanim ja suurim reisikogukond.')
                )
            )


            ->with('contentA', collect()
                ->push(component('ExperimentGrid')
                    ->with('cols', '50% 50%')
                    ->with('gap', 1.5)
                    ->with('items', collect()
                        ->push(component('ExperimentCard')
                            ->is('large')
                            ->with('height', 15 + 15 + 1.5)
                            ->with('title', $news->first()->vars()->title)
                            ->with(
                                'background',
                                $news->first()->imagePreset('large')
                            )
                        )
                        ->push(component('ExperimentGrid')
                            ->with('gap', 1.5)
                            ->with('cols', '50% 50%')
                            ->with('items', $news->slice(1)->take(4)->map(function ($new) {
                                return component('ExperimentCard')
                                    ->with('title', $new->vars()->title)
                                    ->with(
                                        'background',
                                        $new->imagePreset('medium')
                                    );
                            }))
                        )
                    )
                )
            )
            ->with('contentB', collect()
                ->push(component('ExperimentGrid')
                    ->with('cols', '20% 37% 37%')
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
                    ->with('items', $news->take(4)->map(function ($new) {
                        return region('NewsCard', $new);
                    }))
                )
                ->push(component('Placeholder')
                    ->with('title', 'Bottom1, part 2')
                )
            )

            ->with('bottom1', collect())

            ->with('bottom2', collect()
                ->push(region('PhotoRow', $photos))
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
