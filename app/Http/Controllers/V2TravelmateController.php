<?php

namespace App\Http\Controllers;

use Request;
use App\Content;
use App\Destination;
use App\Topic;

class V2TravelmateController extends Controller
{
    public function index()
    {
        $currentDestination = Request::get('destination');
        $currentTopic = Request::get('topic');

        $travelmates = Content::getLatestPagedItems('travelmate', false, $currentDestination, $currentTopic);
        $forums = Content::getLatestItems('forum', 5);
        $flights = Content::getLatestItems('flight', 3);
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
                ->push(component('Paginator')
                    ->with('links', $travelmates->appends([
                        'destination' => $currentDestination,
                        'topic' => $currentTopic,
                    ])
                    ->links())
                )
            )

            ->with('sidebar', collect()
                ->push(component('Block')->with('content', collect()
                    ->push(region(
                        'Filter',
                        $destinations,
                        $topics,
                        $currentDestination,
                        $currentTopic,
                        $travelmates->currentPage(),
                        'v2.travelmate.index'
                    ))
                ))
                ->push(region('TravelmateAbout'))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
            )

            ->with('bottom', collect()
                ->push(region('ForumBottom', $forums))
                ->push(region('FlightBottom', $flights))
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
                ->merge($travelmate->destinations->map(function ($destination) {
                    return region('DestinationBar', $destination, $destination->getAncestors());
                }))
                ->merge($flights->map(function ($flight) {
                    return region('FlightCard', $flight);
                }))
                ->push(region('ForumSidebar', $forums))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
            )

            ->with('bottom', collect()
                ->push(region('TravelmateBottom', $travelmates))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }
}
