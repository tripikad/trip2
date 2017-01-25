<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;

class V2DestinationController extends Controller
{
    public function show($id)
    {
        $destination = Destination::findOrFail($id);

        $photos = Content::getLatestPagedItems('photo', 9, $destination->id);
        $forums = Content::getLatestPagedItems('forum', 8, $destination->id);

        $flights = Content::getLatestPagedItems('flight', 6, $destination->id);
        $travelmates = Content::getLatestPagedItems('travelmate', 6, $destination->id);
        $news = Content::getLatestPagedItems('news', 2, $destination->id);

        $loggedUser = request()->user();

        return layout('2col')

            ->with('head_description', trans('site.description.destination', [
                'name' => $destination->vars()->name,
            ]))

            ->with('title', $destination->vars()->name)

            ->with('header', region('DestinationHeader', $destination))

            ->with('top', region(
                'PhotoRow',
                $photos->count() ? $photos : collect(),
                collect()
                    ->pushWhen(
                        $photos->count(),
                        component('Button')
                            ->is('transparent')
                            ->with('title', trans('content.photo.more'))
                            ->with('route', route(
                                'photo.index',
                                ['destination' => $destination->id]
                            ))
                    )
                    ->pushWhen(
                        $loggedUser && $loggedUser->hasRole('regular'),
                        component('Button')
                            ->is('transparent')
                            ->with('title', trans('content.photo.create.title'))
                            ->with('route', route('photo.create'))
                    )

            ))

            ->with('content', collect()
                ->push(component('Block')
                    ->with('title', trans('destination.show.forum.title'))
                    ->with('route', route('forum.index', ['destination' => $destination]))
                    ->with('content', $forums->map(function ($forum) {
                        return region('ForumRow', $forum);
                    })
                    )
                )
                ->push(component('Promo')->with('promo', 'body'))
            )

            ->with('sidebar', collect()
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(region('DestinationBottom', $flights, $travelmates, $news, $destination))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function showSlug($slug)
    {
        $destination = Destination::findBySlugOrFail($slug);

        return $this->show($destination->id);
    }
    
}
