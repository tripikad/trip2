<?php

namespace App\Http\Controllers;

use App;
use App\Content;

class FeedController extends Controller
{
    public function flightsFeed()
    {
        $feed = App::make('feed');

        $feed->setCache(config('cache.feed.atom'));

        if (!$feed->isCached()) {
            $feed->title = config('site.name');
            $feed->description = trans('site.description');
            $feed->link = route('feed');
            $feed->setShortening(false);

            $contents = Content::whereType('flight')->whereStatus(1)->latest()->take(15)->get();

            foreach ($contents as $content) {
                $feed->add(
                    $content->title,
                    $content->user->name,
                    route('content.show', [$content->type, $content->id], true),
                    $content->created_at,
                    $content->body_filtered,
                    $content->body_filtered
                );
            }
        }

        return $feed->render('atom');
    }
}
