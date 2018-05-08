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

    public function indexGrid()
    {
        $photos = Content::getLatestItems('photo', 6);

        return layout('Two')
            ->with('content', collect()
                ->push(component('Title')
                    ->is('small')
                    ->with('title', 'Flexbox grid')
                )
                ->push(component('Code')
                    ->is('gray')
                    ->with('code', "component('Grid')
    ->with('cols', 2) // Default is 3
    ->with('items', \$photos->take(4)->...)"
                ))
                ->push(component('Grid')
                    ->with('cols', 2)
                    ->with('items', $photos->take(4)->map(function ($photo) {
                        return component('ExperimentalCard')
                            ->with('title', $photo->vars()->shortTitle)
                            ->with('background', $photo->imagePreset('medium'));
                    }))
                )
                ->push(component('Title')
                    ->is('small')
                    ->with('title', 'Flexbox grid II')
                )
                ->push(component('Code')
                    ->is('gray')
                    ->with('code', "component('Grid')
    ->with('gap', 1) // \$spacer * 1 || 2
    ->with('widths', '2 3 2') // maps to flex:2, flex:3, flex:2 on columns
    ->with('items', \$photos->take(6)->...)"
                ))
                ->push(component('Grid')
                    ->with('gap', 1)
                    ->with('widths', '2 3 2')
                    ->with('items', $photos->take(6)->map(function ($photo) {
                        return component('ExperimentalCard')
                            ->with('title', $photo->vars()->shortTitle)
                            ->with('background', $photo->imagePreset('medium'));
                    }))
                )
                ->push(component('Title')->is('small')->with('title', 'CSS grid'))
                ->push(component('Body')->with('body', 'Only supported in <a href="https://caniuse.com/css-grid">latest browsers</a>'))
                ->push(component('Code')
                    ->is('gray')
                    ->with('code', "component('ExperimentalGrid')
    ->with('gap', 1) // \$spacer * anything
    ->with('widths', '1fr 2fr') // maps to grid-template-columns
    ->with('heights', '2fr 1fr 2fr') // maps to grid-template-rows
    ->with('items', \$photos->take(6)->...)"
                ))
                ->push(component('ExperimentalGrid')
                    ->with('gap', 1)
                    ->with('widths', '1fr 2fr')
                    ->with('heights', '2fr 1fr 2fr')
                    ->with('items', $photos->map(function ($photo) {
                        return component('ExperimentalCard')
                            ->with('title', $photo->vars()->shortTitle)
                            ->with('background', $photo->imagePreset('medium'));
                    }))
                )
            )
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

    public function titleBar($title, $icon)
    {
        return c('Bar')
            ->w('content', collect()
                ->push(c('Icon')->w('size', 'xxl')->w('icon', $icon))
                ->push(c('Title')->i('large')->w('title', $title))
            );
    }

    public function indexList()
    {
        $forums = Content::getLatestItems('forum', 8);

        $titles = c('Grid')
            ->w('cols', 2)
            ->w('items', collect() // content!
                ->push($this->titleBar('Üldfoorum', 'icon-comment'))
                ->push($this->titleBar('Reisikaaslased', 'icon-comment'))
            );

        $forums = c('Grid')
            ->w('cols', 2)
            ->w('items', collect() // content!
                ->push($forums
                    ->map(function ($forum) {
                        return region('ForumRow', $forum);
                    })
                    ->render()
                    ->implode('<br>')
                )
                ->push($forums
                    ->map(function ($forum) {
                        return region('ForumRow', $forum);
                    })
                    ->render()
                    ->implode('<br>')
                )
            );

        return layout('ExperimentalList')
            ->w('background', c('BackgroundMap'))
            ->w('content', collect()
                ->push(c('Container')
                    ->i('wide')
                    ->i('gray')
                    ->with('content', collect()
                        ->push('<br><br><br>')
                        ->push($titles)
                        ->push('<br>')
                        ->push($forums)
                    )
                )
            )
            ->render();
    }

    public function indexList2()
    {
        $flights = Content::getLatestItems('flight', 4);
        $news = Content::getLatestItems('shortnews', 5);
        $forums = Content::getLatestItems('forum', 24);
        $buysells = Content::getLatestItems('buysell', 4);
        $expats = Content::getLatestItems('expat', 4);
        $miscs = Content::getLatestItems('misc', 4);
        $travelmates = Content::getLatestItems('misc', 4);
        $photos = Content::getLatestItems('photo', 16);

        $flightContent = collect()
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
                        ->is('stretched')
                        ->is('darkened')
                        ->with('background', $flight->imagePreset('medium'))
                        ->with('title', ($index == 1 ? 'See on nüüd küll päris eriline pakkumine, kas sa ei leia? ' : '').$flight->vars()->title);
                }))
            );

        $newsContent = component('Grid')
            ->with('cols', 5)
            ->with('gap', 1)
            ->with('items', $news->map(function ($new) {
                return collect()
                    ->push(component('ExperimentalCard')
                        ->with('height', 8)
                        ->with('background', $new->imagePreset('medium'))
                    )
                    ->push('<br>')
                    ->push(component('Title')
                        ->is('small')
                        //->is('blue')
                        ->with('title', $new->vars()->shortTitle)
                    )
                    ->push(component('MetaLink')
                        ->with('title', 'Some text comes here')
                    )
                    //->push('<br>')
                    ->render()
                    ->implode('');
            }));

        $forumContent = component('Grid')
            ->with('cols', 3)
            ->with('widths', '6 1 3')
            ->with('items', collect()
                ->push(collect()
                    ->push(component('Title')
                        ->is('gray')
                        ->is('large')
                        ->with('title', 'Üldfoorum')
                    )
                    ->push(component('Body')
                        ->is('gray')
                        ->with('body', trans('site.description.forum'))
                    )
                    ->merge($forums->map(function ($forum) {
                        return '<br><br>'.region('ForumRow', $forum);
                    }))
                    ->push('<br>')
                    ->render()
                    ->implode('')
                )
                ->push('')
                ->push(collect()
                    ->push(component('Title')
                        ->is('gray')
                        ->is('large')
                        ->with('title', 'Ost-müük')
                    )
                    ->push(component('Body')
                        ->is('gray')
                        ->with('body', trans('site.description.buysell'))
                    )
                    ->merge($buysells->map(function ($buysell) {
                        return '<br><br>'.region('ForumRow', $buysell);
                    }))
                    ->push('<br><br>')
                    ->push(component('Title')
                        ->is('gray')
                        ->is('large')
                        ->with('title', 'Expat')
                    )
                    ->push(component('Body')
                        ->is('gray')
                        ->with('body', trans('site.description.expat'))
                    )
                    ->merge($expats->map(function ($expat) {
                        return '<br>'.region('ForumRow', $expat);
                    }))
                    ->push('<br><br>')
                    ->push(component('Title')
                        ->is('gray')
                        ->is('large')
                        ->with('title', 'Vaba teema')
                    )
                    ->push(component('Body')
                        ->is('gray')
                        ->with('body', trans('site.description.misc'))
                    )
                    ->merge($miscs->map(function ($misc) {
                        return '<br>'.region('ForumRow', $misc);
                    }))
                    ->push('<br><br>')
                    ->push(component('Title')
                        ->is('gray')
                        ->is('large')
                        ->with('title', 'Reisikaaslased')
                    )
                    ->push(component('Body')
                        ->is('gray')
                    )
                    ->merge($travelmates->map(function ($travelmate) {
                        return '<br>'.region('ForumRow', $travelmate);
                    }))
                    ->render()
                    ->implode('')
                )
            );

        $photoContent = component('Grid')
            ->with('cols', 8)
            ->with('items', $photos->map(function ($photo, $index) {
                return component('ExperimentalCard')
                    ->with('height', 14)
                    ->with('background', $photo->imagePreset('medium'));
            }));

        return layout('ExperimentalList')
            ->with('background', component('BackgroundMap'))
            ->with('content', collect()
                ->push(component('Container')
                    ->with('content', $flightContent)
                )
                ->push(component('Container')
                    ->is('wide')
                    ->is('verticallyPadded')
                    ->with('content', collect()
                        ->push('<br><br>')
                        ->push(component('Title')
                            ->is('blue')
                            ->is('large')
                            ->with('title', 'Uudised')
                        )
                        ->push('<br>')
                        ->push($newsContent)
                    )
                )
                ->push('<br>')
                ->push($photoContent)
                ->push(component('Container')
                    ->is('wide')
                    ->is('gray')
                    ->with('content', collect()
                        ->push('<br><br><br>')
                        ->push($forumContent)
                    )
                )
            )
            ->render();
    }
}
