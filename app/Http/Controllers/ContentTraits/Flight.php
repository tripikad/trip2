<?php

namespace App\Http\Controllers\ContentTraits;

use App\Main;
use App\Content;
use App\Destination;

trait Flight
{
    public function getFlightIndex($contents, $topics)
    {
        $viewVariables = [];

        $types = [
            'about' => [
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
                'whereBetween' => Main::getExpireData('buysell') +
                    ['only' => 'buysell'],
            ],
        ];

        $viewVariables = Main::getContentCollections($types);

        /* To-do V2
        $topicsLimit = 12;
        $uniqueTopics = [];

        foreach ($contents as $content) {
            if (count($content->topics)) {
                foreach ($content->topics as $topic) {
                    if (count($uniqueTopics) == $topicsLimit) {
                        break 2;
                    }

                    if (! in_array($topic->name, $uniqueTopics)) {
                        $uniqueTopics[] = [
                            'name' => $topic->name,
                            'id' => $topic->id,
                        ];
                    }
                }
            }
        }

        if (! count($uniqueTopics)) {
            $topics = $topics->take($topicsLimit);

            if (count($topics)) {
                foreach ($topics as $id => $name) {
                    $uniqueTopics[] = [
                        'name' => $name,
                        'id' => $id,
                    ];
                }
            }
        }

        $uniqueTopics = collect($uniqueTopics);

        $viewVariables['uniqueTopics'] = $uniqueTopics;*/

        return $viewVariables;
    }

    public function getFlightShow($content)
    {
        $viewVariables = [];

        $destination_ids = $content->destinations->pluck('id')->toArray();
        $topic_ids = $content->topics->pluck('id')->toArray();

        $destination = null;
        $parent_destination = null;

        $flights_take = [
            'side' => 2,
            'middle' => 4,
            'bottom' => 3,
        ];

        $sidebar_flights = Content::with('destinations')
            ->whereHas('destinations', function ($query) use ($destination_ids) {
                $query->whereIn('content_destination.destination_id', $destination_ids);
            })
            ->where('type', 'flight')
            ->whereNotIn('id', [$content->id])
            ->whereStatus(1)
            ->orderBy('created_at', 'desc')
            ->get();

        if (count($sidebar_flights)) {
            $sidebar_flights = $sidebar_flights->groupBy('destination_id')->max()->take($flights_take['side']);

            $destination = $sidebar_flights->first()->destinations->first();
            if ($destination) {
                $parent_destination = $destination->parent()->first();
            }
        }

        $usedIds = $sidebar_flights->pluck('id');
        $usedIds[] = $content->id;

        $flights_sum = round($flights_take['middle'] + $flights_take['bottom']);
        $types = [
            'about' => [
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
                'whereBetween' => Main::getExpireData('buysell') +
                    ['only' => 'buysell'],
            ],
            'flights' => [
                'notId' => $usedIds,
                'take' => $flights_sum,
                'type' => ['flight'],
                'status' => 1,
                'latest' => 'created_at',
                'whereBetween' => Main::getExpireData('flight'),
            ],
        ];

        $viewVariables = Main::getContentCollections($types);

        $bodyFlights = $viewVariables['flights']->chunk($flights_take['middle']);

        $viewVariables['flights'] = $bodyFlights->first();
        if (count($bodyFlights) > 1) {
            $viewVariables['flights2'] = $bodyFlights->last();
        } else {
            $viewVariables['flights2'] = null;
        }

        if (isset($viewVariables['flights']) && count($viewVariables['flights'])) {
            $usedIds = $usedIds->merge($viewVariables['flights']->pluck('id'));
        }

        $types = [
            'forums' => ['forum', 'expat', 'buysell'],
            'travel_mates' => ['travelmate'],
        ];

        $take = [
            'forums' => 4,
            'travel_mates' => 3,
        ];

        foreach ($types as $key => $type) {
            $viewVariables[$key] = Content::select(['*', 'contents.id AS id'])->
            join('content_destination', 'content_destination.content_id', '=', 'contents.id')
                ->leftJoin('content_topic', 'content_topic.content_id', '=', 'contents.id')
                ->whereIn('contents.type', $type)
                ->where('contents.status', 1)
                ->whereNotIn('contents.id', $usedIds)
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
                ->take($take[$key])
                ->get();
        }

        $usedIds = [];
        if (count($destination)) {
            $usedIds[] = $destination->id;
        }

        $viewVariables['destination'] = $destination;
        $viewVariables['parent_destination'] = $parent_destination;
        $viewVariables['sidebar_flights'] = $sidebar_flights;
        $viewVariables['sidebar_destinations'] = $content->destinations->filter(function ($item) use ($usedIds) {
            return ! in_array($item->id, $usedIds);
        });
        $viewVariables = Main::getParentDestinations(['sidebar_destinations'], $viewVariables, true);

        return $viewVariables;
    }
}
