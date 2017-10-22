<?php

namespace App;

use Cache;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    const Poll = 'poll';
    const Quiz = 'quiz';
    const Questionnaire = 'questionnaire';
    const CacheTTL = 15;

    protected $table = 'poll';

    protected $fillable = ['name', 'start_date', 'end_date', 'type'];

    public $timestamps = false;

    public function content()
    {
        return $this->belongsTo('App\Content', 'id', 'id');
    }

    public function poll_fields()
    {
        return $this->hasMany('App\PollField', 'poll_id', 'id');
    }

    public function poll_results()
    {
        return $this->hasMany('App\PollResult', 'poll_id', 'id');
    }

    public function scopeGetLatestPagedItems(
        $query,
        $take = 36,
        $order = 'poll.id',
        $order_type = 'desc'
    ) {
        if (empty($order)) {
            $order = session('poll.table.order', 'poll.id');
        }

        if (strpos($order, 'poll.') !== 0) {
            $order = 'poll.'.$order;
        }

        if (empty($order_type)) {
            $order_type = session('poll.table.order_type', 'desc');
        }

        session(['poll.table.order' => $order, 'poll.table.order_type' => $order_type]);

        $name = session('poll.table.search.name', false);
        $start = session('poll.table.search.start', false);
        $end = session('poll.table.search.end', false);
        $active = session('poll.table.search.active', false);

        return $query
            ->with('content')
            ->withCount(['poll_results' => function ($query) {
                $query->limit(1); // We only need confirmation that there is atleast one
            }])
            ->when($name, function ($query) use ($name) {
                return $query->where('poll.name', $name);
            })
            ->when($start && $end, function ($query) use ($start, $end) {
                return $query->where('poll.start_date', '>=', $start)
                    ->where('poll.end_date', '<=', $end);
            })
            ->when($start && ! $end, function ($query) use ($start) {
                return $query->where('poll.start_date', $start);
            })
            ->when($end && ! $start, function ($query) use ($end) {
                return $query->where('poll.end_date', $end);
            })
            ->when(($active == 1 || $active == 0) && $active !== false, function ($query) use ($active) {
                return $query->join('contents', 'poll.id', '=', 'contents.id')
                            ->where('contents.status', intval($active));
            })
            ->orderBy($order, $order_type)
            ->distinct()
            ->simplePaginate($take);
    }

    public function scopeGetPollById($query, $id)
    {
        return $query
            ->with([
                'content',
                'content.destinations',
                'poll_fields',
                'poll_results',
            ])
            ->withCount(['poll_fields', 'poll_results'])
            ->findOrFail($id);
    }

    public function scopeGetPollBySlug($query, $slug)
    {
        return $query
            ->with([
                'content',
                'content.destinations',
                'poll_fields',
                'poll_results',
            ])
            ->whereHas('content', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->first();
    }

    public function scopeGetUserAnswers($query, $poll_id)
    {
        return $query
            ->whereHas('poll_results', function ($query) {
                $logged_user = request()->user();
                if ($logged_user) {
                    $query->where('poll_results.user_id', $logged_user->id);
                }
            })
            ->where('id', $poll_id)
            ->get();
    }

    public function scopeGetPollsByDestinationId($query, $destination_id)
    {
        return $query
            ->with(
                'poll_fields',
                'poll_results'
            )
            ->withCount(['poll_fields', 'poll_results'])
            ->whereHas('content', function ($query) {
                $query->where('status', 1);
            })
            ->whereHas('content.destinations', function ($query) use ($destination_id) {
                $query->where('destinations.id', $destination_id);
            })
            ->where('type', self::Poll)
            ->where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))
            ->orderBy('start_date', 'DESC')
            ->get();
    }

    public function scopeGetPollsWoDestination($query)
    {
        return $query
            ->with(
                'poll_fields',
                'poll_results'
            )
            ->withCount(['poll_fields', 'poll_results'])
            ->whereHas('content', function ($query) {
                $query->where('status', 1);
            })
            ->doesntHave('content.destinations')
            ->where('type', self::Poll)
            ->where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))
            ->orderBy('start_date', 'DESC')
            ->get();
    }

    public function scopeGetUnansweredQuizOrQuestionnaire($query)
    {
        $query->whereHas('content', function ($query) {
            $query->where('status', 1);
        })
            ->with('content')
            ->whereIn('type', [self::Quiz, self::Questionnaire])
            ->where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))
            ->orderBy('start_date', 'DESC')
            ->limit(1);

        if (request()->user()) {
            $query->whereDoesntHave('poll_results', function ($query) {
                $query->where('poll_results.user_id', request()->user()->id);
            });
        }

        return $query->get();
    }

    public static function getPollInfoDestination($dest_id)
    {
        $poll_info = self::getPollInfoFromCache(Cache::get('dest_'.$dest_id.'_poll_id'));

        if (! request()->user() && isset($poll_info->results) && count($poll_info->results) == 0) {
            return collect();
        } else if ($poll_info->count() == 7) {
            return $poll_info;
        }

        $polls = self::getPollsByDestinationId($dest_id);

        if ($polls->isEmpty()) {
            return collect();
        }

        $poll = $polls->first();

        Cache::put('dest_'.$dest_id.'_poll_id', $poll->id, Poll::CacheTTL);

        return self::getPollInfo($poll);
    }

    public static function getPollInfoWoDestination()
    {
        $poll_info = self::getPollInfoFromCache(Cache::get('poll_id'));

        if (! request()->user() && isset($poll_info->results) && count($poll_info->results) == 0) {
            return collect();
        } else if ($poll_info->count() == 7) {
            return $poll_info;
        }

        $polls = Poll::getPollsWoDestination();

        if ($polls->isEmpty()) {
            return collect();
        }

        $poll = $polls->first();

        Cache::put('poll_id', $poll->id, Poll::CacheTTL);

        return self::getPollInfo($poll);
    }

    protected static function getPollInfoFromCache($poll_id)
    {
        $info = [];

        if ($poll_id !== null) {
            $info['id'] = $poll_id;
        } else {
            return collect();
        }

        $poll_type = Cache::get('poll_'.$poll_id.'_field_type');
        if ($poll_type !== null) {
            $info['type'] = $poll_type;
        }

        $poll_options = Cache::get('poll_'.$poll_id.'_options');
        if ($poll_options !== null) {
            $info['options'] = json_decode($poll_options, true);
        }

        $image_small = Cache::get('poll_'.$poll_id.'_image_small');
        if ($image_small !== null) {
            $info['image_small'] = $image_small;
        }

        $image_large = Cache::get('poll_'.$poll_id.'_image_large');
        if ($image_large !== null) {
            $info['image_large'] = $image_large;
        }

        $results = Cache::get('poll_'.$poll_id.'_results');
        if ($results === null || request()->user() && self::getUserAnswers($poll_id)->isEmpty()) {
            $info['results'] = [];
        } else if ($results !== null) {
            $info['results'] = json_decode($results, true);
        }

        $count = Cache::get('poll_'.$poll_id.'_count');
        if ($count !== null) {
            $info['count'] = $count;
        }

        return collect($info);
    }

    protected static function getPollInfo(Poll $poll)
    {
        $poll_field = $poll->poll_fields->first();
        $poll_results = $poll_field->getParsedResults();

        $options = json_decode($poll_field->options, true);
        $image_small = '';
        $image_large = '';

        if (isset($options['image_id'])) {
            $image = Image::findOrFail($options['image_id']);
            $image_small = $image->preset('xsmall_square');
            $image_large = $image->preset('large');
        }

        $count = $poll->poll_results_count / $poll->poll_fields_count;

        Cache::put('poll_'.$poll->id.'_field_type', $poll_field->type, Poll::CacheTTL);
        Cache::put('poll_'.$poll->id.'_options', $poll_field->options, Poll::CacheTTL);
        Cache::put('poll_'.$poll->id.'_image_small', $image_small, Poll::CacheTTL);
        Cache::put('poll_'.$poll->id.'_image_large', $image_large, Poll::CacheTTL);
        Cache::put('poll_'.$poll->id.'_results', json_encode($poll_results), Poll::CacheTTL);
        Cache::put('poll_'.$poll->id.'_count', $count, Poll::CacheTTL);

        if (request()->user() && self::getUserAnswers($poll->id)->isEmpty()) {
            $poll_results = [];
        }

        if (! request()->user() && count($poll_results) == 0) {
            return collect();
        }

        return collect([
            'id' => $poll->id,
            'type' => $poll_field->type,
            'options' => json_decode($poll_field->options, true),
            'image_small' => '',
            'image_large' => '',
            'results' => $poll_results,
            'count' => $count
        ]);
    }
}
