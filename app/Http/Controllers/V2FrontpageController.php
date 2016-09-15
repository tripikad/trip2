<?php

namespace App\Http\Controllers;

use App\Content;

class V2FrontpageController extends Controller
{
    public function index()
    {
        $type = 'news';

        $photos = Content::getLatestItems('photo', 6);

        return view('v2.layouts.frontpage')

            ->with('header', region('Header', trans('frontpage.index.search.title')))

            ->with('content_first', collect()
                ->push(region('FrontpageGallery', $photos))
                ->push(component('Block')->with('content', collect(['FrontpageFlightCards'])))
            )

            ->with('footer', region('Footer'));
    }
}
