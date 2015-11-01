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

        // 3 latest flights view
        $flights1 = Content::whereType('flight')->whereStatus(1)->latest()->take(3)->get();
        $flights1_modifiers = ['m-yellow', 'm-red', 'm-green'];

        // about us
        $content = Content::where('id', 1534)->first();

        // 5 latest forum posts
        $forums = Content::whereIn('type', ['forum', 'buysell', 'expat'])->whereStatus(1)->latest()->take(5)->get();

        // 2 latest news posts
        $news1 = Content::whereType('news')->whereStatus(1)->latest()->take(2)->get();

        // 5 latest news posts
        $news2 = Content::whereType('news')->whereStatus(1)->latest()->skip(2)->take(5)->get();

        // 5 latest flight offers
        $flights2 = Content::whereType('flight')->whereStatus(1)->latest()->skip(3)->take(5)->get();
        $flights2_modifiers = ['m-blue', 'm-yellow', 'm-green', 'm-red', 'm-purple'];

        // Latest travel letter from blog
        $travelletters = Content::whereType('blog')->whereStatus(1)->latest()->take(1)->get();

        // 8 latest gallery posts
        $photos = Content::whereType('photo')->whereStatus(1)->latest()->take(8)->get();

        // 4 latest travel mates
        $travelmates = Content::whereType('travelmate')->whereStatus(1)->latest()->take(4)->get();
        
        return response()->view('pages.frontpage.index', [
            'destinations' => $destinations,
            'features' => $features,
            'flights1' => $flights1,
            'flights1_modifiers' => $flights1_modifiers,
            'flights2' => $flights2,
            'flights2_modifiers' => $flights2_modifiers,
            'content' => $content,
            'forums' => $forums,
            'news1' => $news1,
            'news2' => $news2,
            'travelletters' => $travelletters,
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
