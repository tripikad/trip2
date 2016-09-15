<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;
use App\Topic;

class V2TravelmateController extends Controller
{
    public function index()
    {
        $travelmates = Content::getLatestPagedItems('travelmate');
        $destinations = Destination::select('id', 'name')->get();
        $topics = Topic::select('id', 'name')->get();

        return view('v2.layouts.2col')

            ->with('header', region('Header', trans('content.travelmate.index.title')))

            ->with('content', collect()
                ->push(component('Grid2')
                        ->with('gutter', true)
                        ->with('items', $travelmates->map(function ($travelmate) {
                            return region('TravelmateCard', $travelmate);
                        })
                    )
                )
            )

            ->with('sidebar', collect()
                ->push(component('Block')->with('content', collect(['TravelmateAbout'])))
                ->push(component('Block')->with('content', collect()
                    ->push(region('Filter', $destinations, $topics))
                    )
                )
                ->push(component('Promo')->with('promo', 'sidebar_small'))
            )

            ->with('bottom', collect()
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }

    public function show($slug)
    {
        $travelmate = Content::getItemBySlug($slug);
        $user = auth()->user();

        $travelmates = Content::getLatestItems('travelmate', 3);
        $forums = Content::getLatestItems('forum', 5);
        $flights = Content::getLatestItems('flight', 3);

        return view('v2.layouts.2col')

            ->with('header', region('Header', trans('content.travelmate.index.title')))

            ->with('content', collect()
                ->push(component('Title')->with('title', $travelmate->vars()->title))
                ->push(component('Meta')
                    ->with('items', collect()
                        ->push(component('MetaLink')
                            ->with('title', $travelmate->vars()->created_at)
                        )
                        ->pushWhen($user && $user->hasRole('admin'), component('MetaLink')
                            ->with('title', trans('content.action.edit.title'))
                            ->with('route', route('content.edit', [$travelmate->type, $travelmate]))
                        )
                        ->merge($travelmate->destinations->map(function ($tag) {
                            return component('Tag')->is('orange')->with('title', $tag->name);
                        }))
                        ->merge($travelmate->topics->map(function ($tag) {
                            return component('Tag')->with('title', $tag->name);
                        }))
                    )
                )
                ->push(component('Body')->is('responsive')->with('body', $travelmate->vars()->body))
                ->push(region('Share'))
                ->merge($travelmate->comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
                ->pushWhen(
                    $user && $user->hasRole('regular'),
                    region('CommentCreateForm', $travelmate)
                )
            )

            ->with('sidebar', collect()
                ->push(region('UserCard', $travelmate->user))
                ->push(component('Block')->with('content', collect(['DestinationBar'])))
                ->merge($flights->map(function ($flight) {
                    return region('FlightCard', $flight);
                }))
                ->push(region('ForumSidebar', $forums))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
            )

            ->with('bottom', collect()
                ->push(component('Grid3')
                    ->with('gutter', true)
                    ->with('items', $travelmates->map(function ($travelmate) {
                        return region('TravelmateCard', $travelmate);
                    })
                ))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }
}
