<?php

namespace App\Http\Controllers;

use App\Image;
use App\Content;

class CampaignController extends Controller
{
    public function airBaltic()
    {
        $flights = Content::getLatestItems('flight', 3);
        $travelmates = Content::getLatestItems('travelmate', 3);
        $forums = Content::getLatestItems('forum', 3);
        //$news = Content::getLatestItems('news', 1);

        return layout('Full')
            ->with('title', trans('content.forum.index.title'))
            ->with('head_title', 'Airbaltic kampaania')
            ->with('head_description', 'Airbaltic kampaania kirjeldus')
            ->with('head_image', Image::getSocial())
            //->with('background', component('BackgroundMap'))
            ->with('color', 'white')

            ->withItems(
                collect()
                    ->push(region('StaticHeader'))
                    ->push(component('AirBalticCampaign')->with('bottom', region('NewsBottom', $flights, $forums, $travelmates)))
                    ->push(region('Footer'))
            )

            ->render();
    }
}