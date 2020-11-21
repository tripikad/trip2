<?php

namespace App\Http\Controllers;

use Log;
use Request;
use App\User;
use App\Image;
use App\Content;
use App\Destination;

class PhotoController extends Controller
{
    public function index($destinationId = null)
    {
        $destination = $destinationId ? Destination::findOrFail($destinationId) : null;

        $photos = Content::getLatestPagedItems('photo', 5 * 20, $destinationId);
        $loggedUser = request()->user();

        return layout('Full')
            ->withItems(
                collect()
                    ->push(
                        component('Section')
                            ->withPadding(2)
                            ->withTag('header')
                            ->withItems(collect()->push(region('NavbarDark')))
                    )
                    ->push(
                        component('Section')
                            ->withPadding(2)
                            ->withGap(1)
                            ->withAlign('center')
                            ->withItems(
                                collect()
                                    ->spacer(2)
                                    ->push(
                                        component('Title')
                                            ->is('large')
                                            ->withTitle(
                                                trans('content.photo.index.title') .
                                                    ($destination ? ": $destination->name" : '')
                                            )
                                    )
                                    ->pushWhen(
                                        $loggedUser && $loggedUser->hasRole('regular'),
                                        component('Button')
                                            ->is('narrow')
                                            ->with('title', trans('content.photo.create.title'))
                                            ->with('route', route('photo.create'))
                                    )
                                    ->spacer()
                            )
                    )
                    ->push(
                        component('Section')->withItems(
                            collect()->push(
                                component('Grid')
                                    ->withCols(5)
                                    ->withItems(
                                        $photos->map(function ($photo) use ($loggedUser) {
                                            return component('Photo')
                                                ->vue()
                                                ->withImage($photo->imagePreset('small_square'))
                                                ->withLargeImage($photo->imagePreset('large'))
                                                ->withMeta(
                                                    component('Flex')
                                                        ->withJustify('center')
                                                        ->withItems(
                                                            collect()
                                                                ->push(
                                                                    component('Title')
                                                                        ->is('smallest')
                                                                        ->is('blue')
                                                                        ->withTitle($photo->user->name)
                                                                        ->withRoute(route('user.show', [$photo->user]))
                                                                        ->withExternal(true)
                                                                )
                                                                ->push(
                                                                    component('Title')
                                                                        ->is('smallest')
                                                                        ->is('white')
                                                                        ->withTitle($photo->title)
                                                                )
                                                                ->pushWhen(
                                                                    $loggedUser && $loggedUser->hasRole('admin'),
                                                                    component('PublishButton')
                                                                        ->withPublished($photo->status)
                                                                        ->withPublishRoute(
                                                                            route('content.status', [
                                                                                $photo->type,
                                                                                $photo,
                                                                                1
                                                                            ])
                                                                        )
                                                                        ->withUnpublishRoute(
                                                                            route('content.status', [
                                                                                $photo->type,
                                                                                $photo,
                                                                                0
                                                                            ])
                                                                        )
                                                                )
                                                        )
                                                        ->render()
                                                );
                                        })
                                    )
                            )
                        )
                    )
                    ->push(
                        component('Section')
                            ->withPadding(2)
                            ->withItems(region('Paginator', $photos))
                    )
                    ->push(
                        component('Section')
                            ->withPadding(2)
                            ->withTag('footer')
                            ->withItems(region('FooterLight'))
                    )
            )
            ->render();
    }

    public function userIndex($id)
    {
        $loggedUser = request()->user();

        $user = User::findOrFail($id);

        $photos = $user
            ->contents()
            ->whereType('photo')
            ->whereStatus(1)
            ->latest()
            ->simplePaginate(89);

        return layout('Full')
            ->withItems(
                collect()
                    ->push(
                        component('Section')
                            ->withPadding(2)
                            ->withTag('header')
                            ->withItems(collect()->push(region('NavbarDark')))
                    )
                    ->push(
                        component('Section')
                            ->withPadding(2)
                            ->withGap(1)
                            ->withAlign('center')
                            ->withItems(
                                collect()
                                    ->spacer(2)
                                    ->push(
                                        component('Title')
                                            ->is('large')
                                            ->withTitle(trans('content.photo.index.title') . ": $user->name")
                                    )
                                    ->pushWhen(
                                        $loggedUser && $loggedUser->hasRole('regular'),
                                        component('Button')
                                            ->is('narrow')
                                            ->with('title', trans('content.photo.create.title'))
                                            ->with('route', route('photo.create'))
                                    )
                                    ->spacer()
                            )
                    )
                    ->push(
                        component('Section')->withItems(
                            collect()->push(
                                component('Grid')
                                    ->withCols(5)
                                    ->withItems(
                                        $photos->map(function ($photo) use ($loggedUser) {
                                            return component('Photo')
                                                ->vue()
                                                ->withImage($photo->imagePreset('small_square'))
                                                ->withLargeImage($photo->imagePreset('large'))
                                                ->withMeta(
                                                    component('Flex')
                                                        ->withJustify('center')
                                                        ->withItems(
                                                            collect()
                                                                ->push(
                                                                    component('Title')
                                                                        ->is('smallest')
                                                                        ->is('blue')
                                                                        ->withTitle($photo->user->name)
                                                                        ->withRoute(route('user.show', [$photo->user]))
                                                                        ->withExternal(true)
                                                                )
                                                                ->push(
                                                                    component('Title')
                                                                        ->is('smallest')
                                                                        ->is('white')
                                                                        ->withTitle($photo->title)
                                                                )
                                                                ->pushWhen(
                                                                    $loggedUser && $loggedUser->hasRole('admin'),
                                                                    component('PublishButton')
                                                                        ->withPublished($photo->status)
                                                                        ->withPublishRoute(
                                                                            route('content.status', [
                                                                                $photo->type,
                                                                                $photo,
                                                                                1
                                                                            ])
                                                                        )
                                                                        ->withUnpublishRoute(
                                                                            route('content.status', [
                                                                                $photo->type,
                                                                                $photo,
                                                                                0
                                                                            ])
                                                                        )
                                                                )
                                                        )
                                                        ->render()
                                                );
                                        })
                                    )
                            )
                        )
                    )
                    ->push(
                        component('Section')
                            ->withPadding(2)
                            ->withItems(region('Paginator', $photos))
                    )
                    ->push(
                        component('Section')
                            ->withPadding(2)
                            ->withTag('footer')
                            ->withItems(region('FooterLight'))
                    )
            )
            ->render();
    }

    public function show($id)
    {
        $photo = Content::whereType('photo')
            ->whereId($id)
            ->whereStatus(1)
            ->first();

        $loggedUser = request()->user();

        if (!$photo) {
            return abort(404);
        }

        return layout('Two')
            ->with(
                'header',
                region(
                    'StaticHeader',
                    collect()
                        ->push(
                            component('Title')
                                ->is('large')
                                ->with('title', $photo->title)
                        )
                        ->pushWhen(
                            $loggedUser && $loggedUser->hasRole('regular'),
                            component('Button')
                                ->is('narrow')
                                ->with('title', trans('content.photo.create.title'))
                                ->with('route', route('photo.create'))
                        )
                        ->push(' ')
                )
            )

            ->with('top', collect()->push(component('Photo')->withPhoto($photo->imagePreset('large'))))

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function create()
    {
        $destinations = Destination::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        return layout('Two')
            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')

            ->with(
                'header',
                region(
                    'Header',
                    collect()->push(
                        component('Title')
                            ->is('white')
                            ->with('title', trans('content.photo.index.title'))
                            ->with('route', route('forum.index'))
                    )
                )
            )

            ->with(
                'content',
                collect()
                    ->push(component('Title')->with('title', trans('content.photo.create.title')))
                    ->push(
                        component('Form2')
                            ->with('route', route('photo.store'))
                            ->with('files', true)
                            ->with(
                                'fields',
                                collect()
                                    ->push(
                                        component('FormUpload')
                                            ->with('title', trans('content.photo.edit.field.file.title'))
                                            ->with('name', 'file')
                                    )
                                    ->push(
                                        component('FormTextarea')
                                            ->with('title', trans('content.photo.edit.field.title.title'))
                                            ->with('name', 'title')
                                            ->with('value', old('title'))
                                            ->with('rows', 2)
                                    )
                                    ->push(
                                        component('FormSelectMultiple')
                                            ->with('name', 'destinations')
                                            ->with('options', $destinations)
                                            ->with('placeholder', trans('content.index.filter.field.destination.title'))
                                    )
                                    ->push(component('FormButton')->with('title', trans('content.create.submit.title')))
                            )
                    )
            )

            ->with(
                'sidebar',
                collect()->push(
                    component('Block')
                        ->is('gray')
                        ->with(
                            'content',
                            collect()
                                ->push(
                                    component('Title')
                                        ->is('smaller')
                                        ->is('red')
                                        ->with('title', trans('content.edit.notes.heading'))
                                        ->with('route', route('forum.index'))
                                )
                                ->push(component('Body')->with('body', trans('content.edit.notes.body')))
                        )
                )
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
            'file' => "required|image|max:$maxfilesize"
        ];

        $this->validate(request(), $rules);

        $photo = $loggedUser->contents()->create([
            'title' => request()->title,
            'type' => 'photo',
            'status' => 1
        ]);

        $filename = Image::storeImageFile(request()->file('file'));
        $photo->images()->create(['filename' => $filename]);

        $photo->destinations()->attach(request()->destinations);

        Log::info('New content added', [
            'user' => $photo->user->name,
            'title' => $photo->title,
            'type' => $photo->type,
            'body' => $photo->body
        ]);

        return redirect()
            ->route('photo.index')
            ->with(
                'info',
                trans('content.store.info', [
                    'title' => $photo->title
                ])
            );
    }
}
