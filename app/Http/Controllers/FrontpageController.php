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
                'skip' => NULL,
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
                'type' => ['content'],
                'id' => 1534,
                'status' => 1,
            ],
            'forums' => [
                'skip' => NULL,
                'take' => 5,
                'type' => ['forum', 'buysell', 'expat'],
                'status' => 1,
                'latest' => true,
            ],
            'news1' => [
                'skip' => NULL,
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
            'blogs' => [
                'skip' => NULL,
                'take' => 1,
                'type' => ['blog'],
                'status' => 1,
                'latest' => true,
            ],
            'photos' => [
                'skip' => NULL,
                'take' => 8,
                'type' => ['photo'],
                'status' => 1,
                'latest' => true,
            ],
            'travelmates' => [
                'skip' => NULL,
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
        $content_query = NULL;
        $i = 0;

        foreach ($types as $key => $type) {
            ++$i;

            $query = NULL;

            if (isset($type['id'])) {
                $query = Content::select(['*', DB::raw('REPEAT(\'' . $key . '\',1) AS `index`')])->where('id', $type['id'])->whereStatus($type['status']);
            } else {
                $query = Content::select(['*', DB::raw('REPEAT(\'' . $key . '\',1) AS `index`')])->whereIn('type', $type['type'])->whereStatus($type['status']);

                if (isset($type['latest']) && $type['latest'] !== NULL) {
                    $query = $query->latest();
                }

                if (isset($type['skip']) && $type['skip'] !== NULL) {
                    $query = $query->skip($type['skip']);
                }

                if (isset($type['take']) && $type['take'] !== NULL) {
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
