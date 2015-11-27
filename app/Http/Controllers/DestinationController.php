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
            'news',
            'flight',
            'travelmate',
            'forum',
            'photo',
            'blog',
        ];

        $features = [];

        foreach ($types as $type) {
            $features[$type]['contents'] = $destination->content()
                ->whereType($type)
                ->with(config("content_$type.frontpage.with"))
                ->latest(config("content_$type.frontpage.latest"))
                ->take(config("content_$type.frontpage.take"))
                ->get();
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
