<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
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
        'data' => 'array'
    ];

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
}
