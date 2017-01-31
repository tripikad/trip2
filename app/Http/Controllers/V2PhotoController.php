<?php

namespace App\Http\Controllers;

use App;
use Request;
use App\User;
use App\Content;
use App\Destination;

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
                        ->with('route', route('photo.create'))
                )
                ->push(' ')
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
        $loggedUser = request()->user();

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
                ->pushWhen(
                    $loggedUser && $loggedUser->hasRole('regular'),
                    component('Button')
                        ->is('narrow')
                        ->with('title', trans('content.photo.create.title'))
                        ->with('route', route('photo.create'))
                )
                ->push(' ')
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

    public function show($id)
    {
        return '';
    }

    public function create()
    {
        return App::make('App\Http\Controllers\ContentController')
            ->create('photo');
    }

    public function edit($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->edit('photo', $id);
    }

    public function store()
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'photo');
    }

    public function update($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'photo', $id);
    }
}
