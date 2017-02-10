<?php

namespace App\Http\Controllers;

use App\Content;

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

    public function photoIndex()
    {
        return response()->json([
            [
                "src" => "http://trip.ee/images/small_square/kanada_7mnt.jpeg",
                "id" => "[[123]]"
            ],
            [
                "src" => "http://trip.ee/images/small_square/Screen-Shot-2017-02-10-at-00.48.55_6wda.png",
                "id" => "[[456]]"
            ],
            [
                "src" => "http://trip.ee/images/small_square/Tel_Aviv_bb7w.jpeg",
                "id" => "[[789]]"
            ]
        ]);
    }
}
