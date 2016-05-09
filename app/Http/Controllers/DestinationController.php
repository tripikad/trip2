<?php

namespace App\Http\Controllers;

use View;
use Cache;
use App\Destination;
use DB;
use App\Main;

class DestinationController extends Controller
{
    public function show($id)
    {
        $destination = Destination::with('flags', 'flags.user')
            ->findOrFail($id);

        $types = [
            'news' => [
                'type' => 'news',
                'with' => ['images'],
                'latest' => 'created_at',
                'take' => 5,
            ],
            'flights' => [
                'type' => 'flight',
                'with' => ['images'],
                'latest' => 'created_at',
                'take' => 2,
            ],
            'flights2' => [
                'type' => 'flight',
                'with' => ['images'],
                'latest' => 'created_at',
                'take' => 3,
                'skip' => 2,
            ],
            'travel_mates' => [
                'type' => 'travelmate',
                'with' => ['images'],
                'latest' => 'created_at',
                'take' => 4,
            ],
            'forum_posts' => [
                'type' => ['forum', 'buysell', 'expat'],
                'with' => ['images'],
                'latest' => 'created_at',
                'take' => 4,
            ],
            'photos' => [
                'type' => 'photo',
                'with' => ['images'],
                'latest' => 'created_at',
                'take' => 8,
            ],
            'blog_posts' => [
                'type' => 'blog',
                'with' => ['images'],
                'latest' => 'created_at',
                'take' => 1,
            ],
        ];

        $featured = [];

        foreach ($types as $type => $attributes) {
            $feature_item = null;

            $feature_item = $destination->content();

            if (isset($types[$type]['type']) && ! is_array($types[$type]['type'])) {
                $feature_item->whereType($types[$type]['type']);
            } else {
                $feature_item->whereIn('type', $types[$type]['type']);
            }

            if (isset($types[$type]['with']) && is_array($types[$type]['with'])) {
                $feature_item->with($types[$type]['with']);
            }

            if (isset($types[$type]['latest'])) {
                $feature_item->latest($types[$type]['latest']);
            }

            if (isset($types[$type]['skip'])) {
                $feature_item->skip($types[$type]['skip']);
            }

            if (isset($types[$type]['take'])) {
                $feature_item->take($types[$type]['take']);
            }

            $featured[$type]['contents'] = $feature_item->with('images')->get();
        }

        $getParentDestinations = [
            'flights2',
        ];
        $viewVariables['flights2'] = $featured['flights2']['contents'];
        $viewVariables = Main::getParentDestinations($getParentDestinations, $viewVariables);
        $featured['flights2']['contents'] = $viewVariables['flights2'];

        $previous_destination = Destination::
            where(DB::raw('CONCAT(`name`, `id`)'), '<', function ($query) use ($id) {
                $query->select(DB::raw('CONCAT(`name`, `id`)'))
                    ->from('destinations')
                    ->where('id', $id);
            })
            ->where('parent_id', $destination->parent_id)
            ->orderBy('name', 'desc')
            ->take(1)
            ->unionAll(
                Destination::where(DB::raw('CONCAT(`name`, `id`)'), '>', function ($query) use ($id) {
                    $query->select(DB::raw('CONCAT(`name`, `id`)'))
                        ->from('destinations')
                        ->where('id', $id);
                })
                ->where('parent_id', $destination->parent_id)
                ->orderBy('name', 'desc')
                ->take(1)
            )
            ->first();

        $next_destination = Destination::
            where(DB::raw('CONCAT(`name`, `id`)'), '>', function ($query) use ($id) {
                $query->select(DB::raw('CONCAT(`name`, `id`)'))
                    ->from('destinations')
                    ->where('id', $id);
            })
            ->where('parent_id', $destination->parent_id)
            ->orderBy('name', 'asc')
            ->take(1)
            ->unionAll(
                Destination::where(DB::raw('CONCAT(`name`, `id`)'), '<', function ($query) use ($id) {
                    $query->select(DB::raw('CONCAT(`name`, `id`)'))
                        ->from('destinations')
                        ->where('id', $id);
                })
                ->where('parent_id', $destination->parent_id)
                ->orderBy('name', 'asc')
                ->take(1)
            )
            ->first();

        /*
         * Baum bug fix.
         * Baum always tries to find result from database.
         *
         * Ex. WHERE id = NULL.
         */
        if ($destination->parent_id) {
            $parent_destination = $destination->parent()->first();
        } else {
            $parent_destination = null;
        }

        if (! $parent_destination) {
            $root_destination = $destination;
        } else {
            $root_destination = $destination->getRoot();
        }

        $destination_info = null;
        if ($destination->depth > 0) {
            if ($destination->depth == 1) {
                $destination_info = $destination;
            } elseif ($destination->depth == 2) {
                $destination_info = $parent_destination;
            } else {
                if ($parent_destination) {
                    $destination_info = Destination::whereId($parent_destination->parent_id)->first();
                }
            }
        }

        $popular_destinations = $root_destination
            ->getPopular()
            ->sortByDesc('interestTotal')
            ->take(4);

        return response()->view('pages.destination.show', [
            'destination' => $destination,
            'featured' => $featured,
            'previous_destination' => $previous_destination,
            'next_destination' => $next_destination,
            'parent_destination' => $parent_destination,
            'root_destination' => $root_destination,
            'popular_destinations' => $popular_destinations,
            'destination_info' => $destination_info,
        ])->header('Cache-Control', 'public, s-maxage='.config('cache.destination.header'));
    }
}
