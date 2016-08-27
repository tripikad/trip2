<?php

namespace App\Http\Controllers;

use App\Content;

class V2FrontpageController extends Controller
{
    public function index()
    {
        $type = 'news';

        $posts = Content::whereType($type)
            ->whereStatus(1)
            ->take(6)
            ->latest()
            ->get();

        $latestimages = Content::whereType('photo')->latest()->take(6)->get()
            ->map(function ($image) {
                return [
                    'id' => $image->id,
                    'small' => $image->imagePreset('small_square'),
                    'large' => $image->imagePreset('large'),
                    'meta' => component('Meta')->with('items', collect()
                        ->push(component('MetaLink')
                            ->with('title', $image->vars()->title)
                        )
                        ->push(component('MetaLink')
                            ->with('title', $image->vars()->created_at)
                        )
                        ->push(component('MetaLink')
                            ->with('title', $image->user->vars()->name)
                            ->with('route', route('user.show', [$image->user]))
                        )
                    )->render(),
                ];
            });

        return view('v2.layouts.frontpage')

            ->with('header', region('Header', 'Search'))

            ->with('content_first', collect()
                ->push(component('Block')
                    ->is('red')
                    ->is('uppercase')
                    ->is('white')
                    ->with('title', 'Viimati lisatud pildid')
                    ->with('content', collect()
                        ->push(component('Gallery')
                            ->with('images', $latestimages)
                        )
                    ))
                    ->push(component('Block')->with('content', collect(['FrontpageFlightCards'])))
            )

            ->with('footer', region('Footer'));
    }
}
