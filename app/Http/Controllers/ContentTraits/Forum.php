<?php

namespace App\Http\Controllers\ContentTraits;

use App\Content;

trait Forum
{
    public function getForumIndex()
    {
        $viewVariables['flights'] = Content::whereType('flight')
            ->whereStatus(1)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return $viewVariables;
    }

    public function getForumShow($content)
    {
        $viewVariables['travel_mates'] = Content::whereType('travelmate')
            ->whereStatus(1)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $viewVariables['flights'] = Content::whereType('flight')
            ->whereStatus(1)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $viewVariables['forums'] = Content::whereIn('type', ['forum', 'expat', 'buysell'])
            ->whereStatus(1)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $destination_ids = $content->destinations->pluck('id')->toArray();
        $topic_ids = $content->topics->pluck('id')->toArray();

        $relation_posts = Content::
        with('destinations')
            ->whereHas('destinations', function ($query) use ($destination_ids) {
                $query->whereIn('destination_id', $destination_ids);
            })
            ->whereIn('type', ['forum', 'expat', 'buysell'])
            ->where('id', '!=', $content->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $first_relative_posts = null;
        $second_relative_posts = null;
        $viewVariables['first_destination'] = null;
        $viewVariables['first_destination_parent'] = null;
        $viewVariables['second_destination'] = null;
        $viewVariables['second_destination_parent'] = null;
        if (count($relation_posts)) {
            $relation_posts = $relation_posts->groupBy(function ($item) {
                return $item->destinations->first()->id;
            })->take(2);

            if (count($relation_posts)) {
                $first_relative_posts = $relation_posts->first()->take(5);
                $viewVariables['first_destination'] = $first_relative_posts->first()->destinations->first();
                $viewVariables['first_destination_parent'] = $first_relative_posts->first()->destinations->first()->parent()->first();
            }

            if (count($relation_posts) > 1) {
                $second_relative_posts = $relation_posts->last()->take(5);
                $viewVariables['second_destination'] = $second_relative_posts->first()->destinations->first();
                $viewVariables['second_destination_parent'] = $second_relative_posts->first()->destinations->first()->parent()->first();
            }
        }

        $viewVariables['first_relative_posts'] = $first_relative_posts;
        $viewVariables['second_relative_posts'] = $second_relative_posts;

        $viewVariables['relative_flights'] = Content::
        join('content_destination', 'content_destination.content_id', '=', 'contents.id')
            ->leftJoin('content_topic', 'content_topic.content_id', '=', 'contents.id')
            ->where('contents.type', 'flight')
            ->where('contents.status', 1)
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
            ->take(2)
            ->get();

        return $viewVariables;
    }
}
