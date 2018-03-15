<?php

namespace App\Http\Controllers;

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

        return layout('Two')

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

        return layout('Two')

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
        $photo = Content::whereType('photo')
            ->whereId($id)
            ->whereStatus(1)
            ->first();

        $loggedUser = request()->user();

        if (! $photo) {
            return abort(404);
        }

        return layout('Two')
            ->with('header', region('StaticHeader', collect()
                ->push(component('Title')
                    ->is('large')
                    ->with(
                        'title',
                        $photo->title
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
                ->push(
                    component('PhotoResponsive')
                        ->with('content',
                            component('PhotoCard')
                                ->with('small', $photo->imagePreset('large'))
                                ->with('large', $photo->imagePreset('large'))
                                ->with('meta', trans('content.photo.meta', [
                                    'title' => $photo->vars()->title,
                                    'username' => $photo->user->vars()->name,
                                    'created_at' => $photo->vars()->created_at,
                                ]))
                                ->with('auto_show', true)
                    )
                )
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function create()
    {
        $destinations = Destination::select('id', 'name')->orderBy('name', 'asc')->get();

        return layout('Two')

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
                    ->with('route', route('photo.store'))
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
}
