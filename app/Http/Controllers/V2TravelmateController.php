<?php

namespace App\Http\Controllers;

use App\Content;

class V2TravelmateController extends Controller
{
    public function index()
    {
        $type = 'travelmate';

        $posts = Content::whereType($type)
            ->whereStatus(1)
            ->skip(40)
            ->take(20)
            ->latest()
            ->get();

        return view('v2.layouts.2col')

            ->with('header', region('Masthead', trans("content.$type.index.title")))

            ->with('content', collect()
                ->push(component('NewsGrid')
                    ->with('items', $posts->map(function ($post) {
                        return region('TravelmateCard', $post);
                    })
                    )
                )
            )

            ->with('sidebar', collect()
                ->push(component('Block')->with('content', collect(['TravelmateAbout'])))
                ->push(component('Block')->with('content', collect(['TravelmateFilter'])))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Block')->with('content', collect(['About'])))
            )

            ->with('bottom', collect()
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }

    public function show($id)
    {
    }
}
