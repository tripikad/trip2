<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Offer extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'body',
        'status',
        'price',
        'data',
        'start_destination',
        'end_destination',
        'start_at',
        'end_at'
    ];

    protected $dates = ['start_at', 'end_at', 'created_at', 'updated_at'];

    protected $casts = [
        'data' => 'object',
        'start_at' => 'date:d.m.Y',
        'end_at' => 'date:d.m.Y'
    ];

    protected $appends = ['duration'];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function startDestination()
    {
        return $this->belongsTo('App\Destination', 'start_destination_id');
    }

    public function endDestination()
    {
        return $this->belongsTo('App\Destination', 'end_destination_id');
    }

    public function scopePublic($query)
    {
        return $query->where('status', 1);
    }

    public function getDurationAttribute()
    {
        return $this->end_at->diffForHumans($this->start_at, true);
    }
}
