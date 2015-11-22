<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Cache;
use App\Content;
use App\Destination;
use Illuminate\Support\Collection;
use DB;

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

        $types = [
            'flights1' => [
                'skip' => null,
                'take' => 3,
                'type' => ['flight'],
                'status' => 1,
                'latest' => true,
            ],
            'flights2' => [
                'skip' => 3,
                'take' => 5,
                'type' => ['flight'],
                'status' => 1,
                'latest' => true,
            ],
            'content' => [
                'take' => 1,
                'id' => 1534,
                'status' => 1,
            ],
            'forums' => [
                'skip' => null,
                'take' => 5,
                'type' => ['forum', 'buysell', 'expat'],
                'status' => 1,
                'latest' => true,
            ],
            'news1' => [
                'skip' => null,
                'take' => 2,
                'type' => ['news'],
                'status' => 1,
                'latest' => true,
            ],
            'news2' => [
                'skip' => 2,
                'take' => 5,
                'type' => ['news'],
                'status' => 1,
                'latest' => true,
            ],
            'featured_news' => [
                'skip' => null,
                'take' => 3,
                'type' => ['sponsored'],
                'status' => 1,
                'latest' => true,
            ],
            'blogs' => [
                'skip' => null,
                'take' => 1,
                'type' => ['blog'],
                'status' => 1,
                'latest' => true,
            ],
            'photos' => [
                'skip' => null,
                'take' => 8,
                'type' => ['photo'],
                'status' => 1,
                'latest' => true,
            ],
            'travelmates' => [
                'skip' => null,
                'take' => 4,
                'type' => ['travelmate'],
                'status' => 1,
                'latest' => true,
            ],
        ];

        $viewVariables = $this->getCollections($types);

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

    public function getCollections($types)
    {
        $content_query = null;
        $i = 0;

        foreach ($types as $key => $type) {
            ++$i;

            $query = null;

            if (isset($type['id'])) {
                $query = Content::select(['*', DB::raw('REPEAT(\''.$key.'\',1) AS `index`')])->where('id', $type['id'])->whereStatus($type['status']);
            } else {
                $query = Content::select(['*', DB::raw('REPEAT(\''.$key.'\',1) AS `index`')])->whereIn('type', $type['type'])->whereStatus($type['status']);

                if (isset($type['latest']) && $type['latest'] !== null) {
                    $query = $query->latest();
                }

                if (isset($type['skip']) && $type['skip'] !== null) {
                    $query = $query->skip($type['skip']);
                }

                if (isset($type['take']) && $type['take'] !== null) {
                    $query = $query->take($type['take']);
                }
            }

            if ($i == 1) {
                $content_query = $query;
            } else {
                $content_query = $content_query->union($query);
            }
        }

        $content_query = $content_query->get();

        $viewVariables = [];

        foreach ($types as $key => $type) {
            $$key = Collection::make($content_query->where('index', $key)->values()->all());

            $viewVariables[$key] = $$key;
        }

        return $viewVariables;
    }
}
