<?php

namespace App\Http\Controllers;

use Request;
use Response;
use App\Destination;
use App\Content;
use App\User;

class V2PhotoController extends Controller
{
    public function index()
    {

        $loggedUser = request()->user();

        $destinationId = Request::get('destination');

        $destinationTitle = $destinationId
            ? ': '.Destination::findOrFail($destinationId)->name
            : '';

        $photos = Content::getLatestPagedItems('photo', 89, $destinationId);

        return layout('1col')

            ->with('header', region('StaticHeader', collect()
                ->push(component('Title')
                    ->is('large')
                    ->with(
                        'title',
                        trans('content.photo.index.title').$destinationTitle
                    )
                )
                ->pushWhen(
                    $loggedUser && $loggedUser->hasRole('regular'),
                    component('Button')
                        ->is('narrow')
                        ->with('title', trans('content.photo.create.title'))
                        ->with('route', route('content.create', ['photo']))
                )
            ))

            ->with('top', collect()
                ->push(region('PhotoRow', $photos))
            )

            ->with('content', collect()
                ->push(region('Paginator', $photos))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function userIndex($id)
    {

        $user = User::findOrFail($id);
        $userTitle = ': '.$user->vars()->name;

        $photos = $user
            ->contents()
            ->whereType('photo')
            ->whereStatus(1)
            ->latest()
            ->simplePaginate(89);

        return layout('1col')

            ->with('header', region('StaticHeader', collect()
                ->push(component('Title')
                    ->is('large')
                    ->with(
                        'title',
                        trans('content.photo.index.title').$userTitle
                    )
                )
            ))

            ->with('top', collect()
                ->push(region('PhotoRow', $photos))
            )

            ->with('content', collect()
                ->push(region('Paginator', $photos))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

}
