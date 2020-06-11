<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $table = 'polls';

    protected $dates = ['start_date', 'end_date'];

    public $timestamps = true;

    protected $appends = [
        'start_date_formatted',
        'end_date_formatted'
    ];

    public function poll_options()
    {
        return $this->hasMany('App\PollOption', 'poll_id', 'id');
    }

    public function results()
    {
        return $this->hasMany('App\PollResult', 'poll_id', 'id');
    }

    public function getStartDateFormattedAttribute()
    {
        return $this->start_date->format('d.m.Y');
    }

    public function getEndDateFormattedAttribute()
    {
        return $this->end_date ? $this->end_date->format('d.m.Y') : null;
    }

    public function getFormattedResults()
    {
        $data = [];
        $total = $this->answered;
        $options = $this->poll_options()
            ->with('results')
            ->get();

        foreach ($options as $option) {
            $results = $option->results;
            $data[] = [
                'title' => $option->name,
                'value' => $total > 0 ? round($results->count() / $total * 100) : 0
            ];
        }

        return $data;
    }

}
