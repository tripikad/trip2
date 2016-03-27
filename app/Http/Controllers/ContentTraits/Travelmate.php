<?php

namespace App\Http\Controllers\ContentTraits;

use Carbon\Carbon;
use App\Content;

trait Travelmate
{
    public function getTravelMateIndex()
    {
        $content = Content::whereIn('id', [1534, 25151])
            ->whereStatus(1)
            ->get();

        $viewVariables['about'] = $content->where('id', 1534);

        $viewVariables['rules'] = $content->where('id', 25151);

        $viewVariables['activity'] = Content::whereType('travelmate')
            ->whereStatus(1)
            ->whereBetween('created_at', [
                Carbon::now(),
                Carbon::now()->addDays(14),
            ])
            ->count();

        return $viewVariables;
    }

    public function getTravelMateShow($content)
    {
        $viewVariables['travel_mates'] = Content::where('id', '!=', $content->id)
            ->whereStatus(1)
            ->whereType('travelmate')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $destination_ids = $content->destinations->lists('id')->toArray();
        $topic_ids = $content->topics->lists('id')->toArray();

        $viewVariables['destination'] = null;
        $viewVariables['parent_destination'] = null;
        $destinationNotIn = [];

        $sidebar_flights = Content::
        with('destinations')
            ->whereHas('destinations', function ($query) use ($destination_ids) {
                $query->whereIn('content_destination.destination_id', $destination_ids);
            })
            ->where('type', 'flight')
            ->whereStatus(1)
            ->orderBy('created_at', 'desc')
            ->get();

        if (count($sidebar_flights)) {
            $sidebar_flights = $sidebar_flights->groupBy('destination_id')->max()->take(2);

            $viewVariables['destination'] = $sidebar_flights->first()->destinations->first();
            if ($viewVariables['destination']) {
                $viewVariables['parent_destination'] = $viewVariables['destination']->parent()->first();
            }

            $destinationNotIn = $sidebar_flights->first()->destinations->lists('id')->toArray();
        }

        $types = [
            'forums' => ['forum', 'expat', 'buysell'],
            'flights' => ['flight'],
        ];

        $viewVariables['sidebar_flights'] = $sidebar_flights;

        foreach ($types as $key => $type) {
            $viewVariables[$key] = Content::
            join('content_destination', 'content_destination.content_id', '=', 'contents.id')
                ->leftJoin('content_topic', 'content_topic.content_id', '=', 'contents.id')
                ->whereIn('contents.type', $type)
                ->where('contents.status', 1)
                ->whereNotIn('content_destination.destination_id', $destinationNotIn)
                ->whereNested(function ($query) use ($destination_ids, $topic_ids) {
                    $query->whereIn(
                        'content_destination.destination_id',
                        $destination_ids
                    )
                        ->orWhereIn(
                            'content_topic.topic_id',
                            $topic_ids
                        );
                })
                ->orderBy('contents.created_at', 'desc')
                ->take(3)
                ->get();
        }

        return $viewVariables;
    }
}
