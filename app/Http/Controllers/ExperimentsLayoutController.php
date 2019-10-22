<?php

namespace App\Http\Controllers;

use App\Content;

class ExperimentsLayoutController extends Controller
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
        $flights = Content::getLatestItems('flight', 3);

        $contentA = collect()
            ->push(component('Grid')
                ->with('cols', $flights->count())
                ->with('items', $flights->map(function ($flight, $index) {
                    return region(
                        'DestinationBar',
                        $flight->destinations()->first(),
                        ['purple', 'yellow', 'red', 'green'][$index]
                    );
                }))
            )
            ->push(component('Grid')
                ->with('cols', $flights->count())
                ->with('items', $flights->map(function ($flight, $index) {
                    return component('ExperimentalCard')
                        ->with('background', $flight->imagePreset('medium'))
                        ->with('title', ($index == 1 ? 'See on nüüd küll päris eriline pakkumine, kas sa ei leia? ' : '').$flight->vars()->title);
                }))
            )
            ->push('<br>')
            ->push(component('Grid')
                ->with('widths', '1 3 1')
                ->with('items', collect()
                    ->push('')
                    ->push(component('Placeholder')
                        ->with('title', 'More offers')
                        ->with('height', 3)
                    )
                    ->push('')
                )
            )
            ->push('<br><br><br>')
            ->push(component('Grid')
                ->is('gutter')
                ->with('widths', '3 1')
                ->with('items', collect()
                    ->push(component('Placeholder')
                        ->with('title', 'About')
                    )
                    ->push(component('Placeholder')
                        ->with('title', 'Register')
                    )
                )
            );

        $contentB = collect()
            ->push('<br><br>')
            ->push(component('Placeholder')
                ->with('height', 20)
                ->with('title', 'News')
            )
            ->push('<br><br>')
            ->push(component('Placeholder')
                ->with('height', 30)
                ->with('title', 'Forum')
            )
            ->push('<br><br>')
            ->push(component('Placeholder')
                ->with('height', 8)
                ->with('title', 'Photos')
            )
            ->push('<br><br>')
            ->push(component('Placeholder')
                ->with('height', 8)
                ->with('title', 'Travelmates + Blogs')
            )
            ->push('<br><br>')
            ->push(component('PlaceholderPromo')
                ->is('lg')
                ->with('title', 'FOOTER')
            )
            ->push('<br><br>');

        return layout('ExperimentalFrontpage')

            ->with('header', region('FrontpageHeader', collect()))

            ->with('contentA', $contentA)
            ->with('contentB', $contentB)

            ->with('footer', region('Footer'))

            ->render();
    }

    public function indexList()
    {
        $flights = Content::getLatestItems('flight', 4);

        $header = collect()
            ->push(component('Grid')
                ->with('cols', $flights->count())
                ->with('items', $flights->map(function ($flight, $index) {
                    return region(
                        'DestinationBar',
                        $flight->destinations()->first(),
                        ['purple', 'yellow', 'red', 'green'][$index]
                    );
                }))
            )
            ->push(component('Grid')
                ->with('cols', $flights->count())
                ->with('items', $flights->map(function ($flight, $index) {
                    return component('ExperimentalCard')
                        ->with('background', $flight->imagePreset('medium'))
                        ->with('title', ($index == 1 ? 'See on nüüd küll päris eriline pakkumine, kas sa ei leia? ' : '').$flight->vars()->title);
                }))
            );

        return layout('ExperimentalList')
            ->with('background', component('BackgroundMap'))
            ->with('content', collect()
                ->push(component('Container')
                    ->with('content', $header->merge(collect()
                        ->push(component('Placeholder'))
                    ))
                )
            )
            ->render();
    }
}
