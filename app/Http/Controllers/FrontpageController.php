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

        $take = [
            'flights1' => 3,
            'flights2' => 5,
            'content' => 1,
            'forums' => 5,
            'news1' => 2,
            'news2' => 5,
            'blogs' => 1,
            'photos' => 8,
            'travelmates' => 4,
        ];

        $collection['content'] = Content::whereType('flight')->whereStatus(1)->latest()
            ->take($take['flights1'])
            ->union(Content::whereType('flight')->whereStatus(1)->latest()
                ->skip($take['flights1'])
                ->take($take['flights2']))
            ->union(Content::where('id', 1534))
            ->union(Content::whereIn('type', ['forum', 'buysell', 'expat'])->whereStatus(1)->latest()
                ->take($take['forums']))
            ->union(Content::whereType('news')->whereStatus(1)->latest()
                ->take($take['news1']))
            ->union(Content::whereType('news')->whereStatus(1)->latest()
                ->skip($take['news1'])
                ->take($take['news2']))
            ->union(Content::whereType('blog')->whereStatus(1)->latest()
                ->take($take['blogs']))
            ->union(Content::whereType('photo')->whereStatus(1)->latest()
                ->take($take['photos']))
            ->union(Content::whereType('travelmate')->whereStatus(1)->latest()
                ->take($take['travelmates']))
            ->get();

        $i = 0;
        $index = 0;
        $previous_value = 0;
        $viewVariables = [];

        foreach($take as $key => $value) {
            ++$i;

            if($i == 1)
                $index = 0;
            else
                $index += $previous_value;

            $$key = collect($collection['content']->slice($index, $value)->all());

            $viewVariables[$key] = $$key;

            $previous_value = $value;
        }

        $viewVariables['destinations'] = $destinations;

        return response()
            ->view('pages.frontpage.index', $viewVariables)
            ->header('Cache-Control', 'public, s-maxage='.config('site.cache.frontpage'));
    }

    public function search(Request $request)
    {
        return redirect()
            ->route('destination.index', [$request->destination]);
    }
}
