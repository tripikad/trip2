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

        return view('v2.layouts.frontpage')

            ->with('header', region('Masthead', ''))

            ->with('content_first', collect()
                ->push(component('FrontpageNews')
                    ->with('items', $posts->map(function ($post) {
                        return region('NewsCard', $post);
                    })
                    )
                )
            )

            ->with('footer', region('Footer'));
    }
}
