<?php

namespace App\Http\Controllers;

use App\Content;
use App\Image;

class V2AdminController extends Controller
{
    public function unpublishedIndex()
    {
        $user = auth()->user();
        $contents = Content::whereStatus(0)->latest()->simplePaginate(50);

        return layout('1col')

            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')

            ->with('header', region('ForumHeader', collect()
                ->pushWhen($user && $user->hasRole('admin'), component('Link')
                    ->with('title', trans('menu.auth.admin'))
                    ->with('route', route('internal.index'))
                )
                ->push(component('Title')
                    ->with('title', trans('admin.content.index.title'))
                )
            ))

            ->with('content', collect()
                ->merge($contents->map(function ($content) {
                    return component('Block')->with('content', collect()
                        ->push(component('Title')
                            ->is('small')
                            ->with('title', $content->vars()->title)
                            ->with('route', route("$content->type.show", [$content->slug]))
                        )
                        ->push(component('MetaLink')
                            ->with('title', collect()
                                ->push(trans("content.$content->type.index.title"))
                                ->push($content->user->vars()->name)
                                ->push($content->vars()->created_at)
                                ->implode(' ')
                            )
                        )
                    );
                }))
                ->push(region('Paginator', $contents))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function imageIndex()
    {
        $user = auth()->user();
        $images = Image::doesntHave('user')
            ->latest()
            ->simplePaginate(36);

        return layout('1col')

            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')

            ->with('header', region('ForumHeader', collect()
                ->pushWhen($user && $user->hasRole('admin'), component('Link')
                    ->with('title', trans('menu.auth.admin'))
                    ->with('route', route('internal.index'))
                )
                ->push(component('Title')
                    ->with('title', trans('admin.image.index.title'))
                )
            ))

            ->with('content', collect()
                ->push(component('FormHorizontal')
                    ->with('files', true)
                    ->with('route', route('image.store'))
                    ->with('fields', collect()
                        ->push(component('FormFile')
                            ->is('hidden')
                            ->with('title', trans('admin.image.create.file.title'))
                            ->with('name', 'image')
                        )
                        ->push(component('FormButton')
                            ->is('hidden')
                            ->with('title', trans('admin.image.create.submit.title'))
                        )
                    )
                )
                ->push(component('FormFileDrop')
                    ->with('route', route('image.store'))
                    ->with('title', trans('image.drop.title'))
                    ->with('name', 'image')
                    ->with('reload', true)
                )
                ->merge($images->chunk(6)->map(function ($chunk) {
                    return component('BlockHorizontal')
                        ->with('content', $chunk->map(function($image) {
                            return collect()
                                ->push(component('PhotoCard')
                                    ->with('small', $image->preset('xsmall_square'))
                                    ->with('large', $image->preset('large'))
                                )
                                ->push(component('FormTextfield')
                                    ->with('value', "[[$image->id]]")
                                    ->with('size', 8)
                                )
                                ->render()
                                ->implode('');
                        }));
                }))
                ->push(region('Paginator', $images))
            )

            ->with('footer', region('FooterLight'))

            ->render();

    }
}
