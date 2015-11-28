<?php

namespace App\Http\Controllers;

use View;
use Cache;
use App\Destination;
use DB;

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
            'travelmates' => [
                'type' => 'travelmate',
                'with' => ['images'],
                'latest' => 'created_at',
                'take' => 4,
            ],
            'forum_posts' => [
                'type' => 'forum',
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

        $features = [];

        foreach ($types as $type => $attributes) {
            $feature_item = null;

            $feature_item = $destination->content();

            if (isset($types[$type]['type'])) {
                $feature_item->whereType($types[$type]['type']);
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

            $features[$type]['contents'] = $feature_item->get();
        }

        $previous_destination = Destination::
            where(DB::raw('CONCAT(`name`, `id`)'), '<', function ($query) use ($id) {
                $query->select(DB::raw('CONCAT(`name`, `id`)'))
                    ->from('destinations')
                    ->where('id', $id);
            })
            ->where('parent_id', $destination->parent_id)
            ->orderBy('name', 'desc')
            ->take(1)
            ->union(
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
            ->union(
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

        $parent_destination = $destination->parent()->first();

        return response()->view('pages.destination.show', [
            'destination' => $destination,
            'features' => $features,
            'previous_destination' => $previous_destination,
            'next_destination' => $next_destination,
            'parent_destination' => $parent_destination,
        ])->header('Cache-Control', 'public, s-maxage='.config('destination.cache'));
    }
}
