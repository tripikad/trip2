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
                ->push(component('Block')->with('content', collect(['NewsFilter'])))
            )

            ->with('footer', region('Footer'));
    }

    public function show($id)
    {
    }

}
