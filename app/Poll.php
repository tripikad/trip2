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
}
