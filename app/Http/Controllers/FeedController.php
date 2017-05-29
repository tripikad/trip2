<?php

namespace App\Http\Controllers;

use App;
use App\Content;

class FeedController extends Controller
{
    public function newsFeed()
    {
        $feed = App::make('feed');
        $feed->ctype = 'text/xml';

        $feed->setCache(config('cache.feed.atom'), 'rssNewsFeed');

        if (! $feed->isCached()) {
            $feed->title = config('site.name');
            $feed->description = trans('site.description.main');
            $feed->link = route('news.feed');
            $feed->setShortening(false);

            $contents = Content::whereType('news')->whereStatus(1)->latest()->take(15)->get();

            foreach ($contents as $content) {
                $feed->add(
                    $content->title,
                    $content->user->name,
                    route($content->type.'.show', [$content->slug], true),
                    $content->created_at,
                    $content->body_filtered,
                    $content->body_filtered
                );
            }
        }

        return $feed->render('rss');
    }

    public function flightFeed()
    {
        $feed = App::make('feed');
        $feed->ctype = 'text/xml';

        $feed->setCache(config('cache.feed.atom'), 'rssFlightsFeed');

        if (! $feed->isCached()) {
            $feed->title = config('site.name');
            $feed->description = trans('site.description.main');
            $feed->link = route('flight.feed');
            $feed->setShortening(false);

            $contents = Content::whereType('flight')->whereStatus(1)->latest()->take(15)->get();

            foreach ($contents as $content) {
                $feed->add(
                    $content->title,
                    $content->user->name,
                    route($content->type.'.show', [$content->slug], true),
                    $content->created_at,
                    $content->body_filtered,
                    $content->body_filtered
                );
            }
        }

        return $feed->render('rss');
    }
}
