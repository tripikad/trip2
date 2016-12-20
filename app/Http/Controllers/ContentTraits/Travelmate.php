<?php

namespace App\Http\Controllers\ContentTraits;

use App\Main;
use App\Content;
use Carbon\Carbon;

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
                Carbon::now()->subDays(14),
                Carbon::now(),
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

        $destination_ids = $content->destinations->pluck('id')->toArray();
        $topic_ids = $content->topics->pluck('id')->toArray();

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

            $destinationNotIn = $sidebar_flights->first()->destinations->pluck('id')->toArray();
        }

        $types = [
            'forums' => ['forum', 'expat', 'buysell'],
            'flights' => ['flight'],
        ];

        $viewVariables['sidebar_flights'] = $sidebar_flights;

        foreach ($types as $key => $type) {
            $viewVariables[$key] = Content::select(['*', 'contents.id AS id'])->
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
                ->groupBy('contents.id');

            if ($key == 'forums') {
                $viewVariables[$key] = $viewVariables[$key]->with(['destinations', 'topics']);
            }

            $viewVariables[$key] = $viewVariables[$key]->orderBy('contents.created_at', 'desc')
                ->take(3)
                ->get();
        }

        /* To-do V2 ?
        $forums = $viewVariables['forums'];
        $forumRelationIds['destinationIds'] = Main::listRelationIds($forums, 'destinations');
        $forumRelationIds['topicIds'] = Main::listRelationIds($forums, 'topics');


        $viewVariables['forum_topic_title'] = $viewVariables['forums']->first()->destinations->find(
            $viewVariables['forums']->first()->destination_id
        )->name;

        $viewVariables['forum_topic_route'] = route('content.index',
            [
                $viewVariables['forums']->first()->type,
                'destination_id='.$viewVariables['forums']->first()->destination_id
            ]);
        */

        return $viewVariables;
    }
}
