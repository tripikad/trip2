<?php

namespace App\Http\Controllers;

use App;
use Log;
use Request;
use App\User;
use App\Image;
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

    public function create2()
    {
        $destinations = Destination::select('id', 'name')->orderBy('name', 'asc')->get();

        return layout('2col')

            ->with('narrow', true)

            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')

            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->with('title', trans('content.photo.index.title'))
                    ->with('route', route('forum.index'))
                )
            ))

            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('content.photo.create.title'))
                )
                ->push(component('Form')
                    ->with('route', route('photo.store2'))
                    ->with('files', true)
                    ->with('fields', collect()
                        ->push(component('FormUpload')
                            ->with('title', trans('content.photo.edit.field.file.title'))
                            ->with('name', 'file')
                        )
                        ->push(component('FormTextarea')
                            ->with('title', trans('content.photo.edit.field.title.title'))
                            ->with('name', 'title')
                            ->with('value', old('title'))
                            ->with('rows', 2)
                        )
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'destinations')
                            ->with('options', $destinations)
                            ->with('placeholder', trans('content.index.filter.field.destination.title'))
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('content.create.submit.title'))
                        )

                    )
                )
            )

            ->with('sidebar', collect()
                ->push(component('Block')
                    ->is('gray')
                    ->with('content', collect()
                        ->push(component('Title')
                            ->is('smaller')
                            ->is('red')
                            ->with('title', trans('content.edit.notes.heading'))
                            ->with('route', route('forum.index'))
                        )
                        ->push(component('Body')
                            ->with('body', trans('content.edit.notes.body'))
                        )
                ))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function store()
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'photo');
    }

    public function store2()
    {
        $loggedUser = request()->user();
        $maxfilesize = config('site.maxfilesize') * 1024;

        $rules = [
            'title' => 'required',
            'file' => "required|image|max:$maxfilesize",
        ];

        $this->validate(request(), $rules);

        $photo = $loggedUser->contents()->create([
            'title' => request()->title,
            'type' => 'photo',
            'status' => 1,
        ]);

        $filename = Image::storeImageFile(request()->file('file'));
        $photo->images()->create(['filename' => $filename]);

        $photo->destinations()->attach(request()->destinations);

        Log::info('New content added', [
            'user' =>  $photo->user->name,
            'title' =>  $photo->title,
            'type' =>  $photo->type,
            'body' =>  $photo->body,
        ]);

        return redirect()
            ->route('photo.index')
            ->with('info', trans('content.store.info', [
                'title' => $photo->title,
            ]));
    }

    // FIXME

    public function edit($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->edit('photo', $id);
    }

    public function update($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'photo', $id);
    }
}
