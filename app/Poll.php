<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
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
            ->when($name, function ($query) use ($name) {
                return $query->where('poll.name', $name);
            })
            ->when($start, function ($query) use ($start) {
                return $query->where('poll.start_date', $start);
            })
            ->when($end, function ($query) use ($end) {
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
            ->with(
                'content',
                'content.destinations',
                'poll_fields',
                'poll_results'
            )
            ->findOrFail($id);
    }

    public function scopeGetPollsByDestinationId($query, $destination_id)
    {
        return $query
            ->with(
                'poll_fields',
                'poll_results'
            )
            ->whereHas('content', function ($query) {
                $query->where('status', 1);
            })
            ->whereHas('content.destinations', function ($query) use ($destination_id) {
                $query->where('destinations.id', $destination_id);
            })
            ->where('type', 'poll')
            ->where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))
            ->orderBy('start_date', 'DESC')
            ->get();
    }

    public function scopeGetUnansweredPollsByDestinationId($query, $destination_id)
    {
        return $query
            ->with(
                'poll_fields'
            )
            ->whereHas('content', function ($query) {
                $query->where('status', 1);
            })
            ->whereHas('content.destinations', function ($query) use ($destination_id) {
                $query->where('destinations.id', $destination_id);
            })
            ->whereDoesntHave('poll_results', function ($query) {
                $logged_user = request()->user();
                if ($logged_user) {
                    $query->where('poll_results.user_id', $logged_user->id);
                }
            })
            ->where('type', 'poll')
            ->where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))
            ->orderBy('start_date', 'DESC')
            ->get();
    }
}
