<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Cache;
use App\Content;
use App\Destination;

class FrontpageController extends Controller
{
    public function index()
    {
        $destinations = Destination::getNames();

        $types = [
            'shortnews',
            'flight',
            'travelmate',
            'forum',
            'photo',
            'blog',
        ];

        $features = [];

        foreach ($types as $type) {
            $features[$type]['contents'] = Content::whereType($type)
                ->with(config("content_$type.frontpage.with"))
                ->latest(config("content_$type.frontpage.latest"))
                ->take(config("content_$type.frontpage.take"))
                ->get();
        }

        // Latest flights view
        $flights1 = Content::whereType('flight')->whereStatus(1)->latest()->take(3)->get();

        // About us
        $content = Content::where('id', 1534)->first();

        // Latest forum posts
        $forums = Content::whereIn('type', ['forum', 'buysell', 'expat'])->whereStatus(1)->latest()->take(5)->get();

        // Latest news posts
        $news1 = Content::whereType('news')->whereStatus(1)->latest()->take(2)->get();

        // Latest news posts
        $news2 = Content::whereType('news')->whereStatus(1)->latest()->skip(2)->take(5)->get();

        // Latest flight offers
        $flights2 = Content::whereType('flight')->whereStatus(1)->latest()->skip(3)->take(5)->get();

        // Latest travel letter from blog
        $blogs = Content::whereType('blog')->whereStatus(1)->latest()->take(1)->get();

        // Latest gallery posts
        $photos = Content::whereType('photo')->whereStatus(1)->latest()->take(8)->get();

        // Latest travel mates
        $travelmates = Content::whereType('travelmate')->whereStatus(1)->latest()->take(4)->get();

        return response()->view('pages.frontpage.index', [
            'destinations' => $destinations,
            'features' => $features,
            'flights1' => $flights1,
            'flights2' => $flights2,
            'content' => $content,
            'forums' => $forums,
            'news1' => $news1,
            'news2' => $news2,
            'blogs' => $blogs,
            'photos' => $photos,
            'travelmates' => $travelmates,
        ])->header('Cache-Control', 'public, s-maxage='.config('site.cache.frontpage'));
    }

    public function search(Request $request)
    {
        return redirect()
            ->route('destination.index', [$request->destination]);
    }
}
