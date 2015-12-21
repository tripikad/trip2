<?php

namespace App\Http\Controllers;

use Feed;
use App\Content;

class FeedController extends Controller
{
    public function index()
    {
        $feed = Feed::make();

        $feed->setCache(config('cache.feed.atom'));

        if (! $feed->isCached()) {
            $feed->title = config('site.name');
            $feed->description = trans('site.description');
            $feed->link = route('feed');
            $feed->setShortening(false);

            $contents = Content::whereType('news')->whereStatus(1)->latest()->take(15)->get();

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
