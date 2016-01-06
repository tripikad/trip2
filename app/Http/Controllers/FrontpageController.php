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
            'flights1' => [
                'skip' => null,
                'take' => 3,
                'type' => ['flight'],
                'status' => 1,
                'latest' => 'created_at',
            ],
            'flights2' => [
                'skip' => 3,
                'take' => 5,
                'type' => ['flight'],
                'status' => 1,
                'latest' => 'created_at',
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
                'latest' => 'created_at',
            ],
            'news' => [
                'skip' => null,
                'take' => 8,
                'type' => ['news'],
                'status' => 1,
                'latest' => 'created_at',
            ],
            'featured_news' => [
                'skip' => null,
                'take' => 3,
                'type' => ['sponsored'],
                'status' => 1,
                'latest' => 'created_at',
            ],
            'blogs' => [
                'skip' => null,
                'take' => 1,
                'type' => ['blog'],
                'status' => 1,
                'latest' => 'created_at',
            ],
            'photos' => [
                'skip' => null,
                'take' => 8,
                'type' => ['photo'],
                'status' => 1,
                'latest' => 'created_at',
            ],
            'travelmates' => [
                'skip' => null,
                'take' => 3,
                'type' => ['travelmate'],
                'status' => 1,
                'latest' => 'created_at',
            ],
        ];

        $findDestinationsParent = [
            'flights1',
        ];

        $viewVariables = $this->getCollections($types);

        $viewVariables['destinations'] = $destinations;

        foreach ($findDestinationsParent as $type) {
            foreach ($viewVariables[$type] as $key => $element) {
                $viewVariables[$type][$key]['destination'] = $element->destinations->first();
                $viewVariables[$type][$key]['parent_destination'] = $element->getDestinationParent();
            }
        }

        return response()
            ->view('pages.frontpage.index', $viewVariables)
            ->header('Cache-Control', 'public, s-maxage='.config('cache.frontpage.header'));
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
        $viewVariables = [];

        foreach ($types as $key => $type) {
            ++$i;

            $query = null;

            if (isset($type['id'])) {
                //$query = Content::select(['*', DB::raw('\''.$key.'\' AS `pseudo`')])->where('id', $type['id'])->whereStatus($type['status']);
                $query = Content::where('id', $type['id'])->whereStatus($type['status']);
            } else {
                //$query = Content::select(['*', DB::raw('\''.$key.'\' AS `pseudo`')])->whereIn('type', $type['type'])->whereStatus($type['status']);
                $query = Content::whereIn('type', $type['type'])->whereStatus($type['status']);

                if (isset($type['with']) && $type['with'] !== null) {
                    $query = $query->with($type['with']);
                }

                if (isset($type['latest']) && $type['latest'] !== null) {
                    $query = $query->latest($type['latest']);
                }

                if (isset($type['skip']) && $type['skip'] !== null) {
                    $query = $query->skip($type['skip']);
                }

                if (isset($type['take']) && $type['take'] !== null) {
                    $query = $query->take($type['take']);
                }
            }

            /*if ($i == 1) {
                $content_query = $query;
            } else {
                $content_query = $content_query->unionAll($query);
            }*/
            $$key = $query->with('images')->get();
            $viewVariables[$key] = $$key;
        }

        //$content_query = $content_query->with('images')->get();

        /*foreach ($types as $key => $type) {
            $$key = Collection::make($content_query->where('pseudo', $key)->values()->all());

            $viewVariables[$key] = $$key;
        }*/

        return $viewVariables;
    }
}
