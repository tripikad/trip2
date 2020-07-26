<?php

namespace App;

use Cache;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Offer extends Model
{
    protected $table = 'offers';

    protected $fillable = [
        'id',
        'status',
        'style',
        'user_id',
        'title',
        'body',
        'data',
        'start_at',
        'end_at',
        'ext_id',
        'ext_date_time'
    ];

    protected $dates = ['start_at', 'end_at', 'created_at', 'updated_at', 'ext_date_time'];

    protected $casts = [
        'data' => 'object',
        'status' => 'boolean'
    ];

    protected $appends = [
        'price',
        'price_formatted',
        'style_formatted',
        'start_at_formatted',
        'end_at_formatted',
        'duration_formatted',
        'coordinates',
        'image',
        'route'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function startDestinations()
    {
        return $this->belongsToMany('App\Destination', 'offer_destination')->wherePivot('type', 'start');
    }

    public function endDestinations()
    {
        return $this->belongsToMany('App\Destination', 'offer_destination')->wherePivot('type', 'end');
    }

    public function scopePublic($query)
    {
        return $query->where('status', 1);
    }

    public function getPriceAttribute($value)
    {
        if ($this->style == 'package') {
            return collect($this->data->hotels)
                ->pluck('price')
                ->map(function ($p) {
                    return only_numbers($p);
                })
                ->filter(function ($p) {
                    return !empty($p);
                })
                ->min();
        }
        if ($this->style !== 'package' && $this->data->price) {
            return $this->data->price;
        }
        return '';
    }

    public function getPriceFormattedAttribute()
    {
        if ($this->price) {
            if ($this->style == 'package') {
                return trans('site.price.starting', [
                    'price' => $this->price,
                    'currency' => config('site.currency.eur')
                ]);
            }
            return trans('site.price', [
                'price' => $this->price,
                'currency' => config('site.currency.eur')
            ]);
        }
    }

    public function getStyleFormattedAttribute()
    {
        if ($style = trans("offer.style.$this->style")) {
            return $style;
        }
        return $this->style;
    }

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }

    public function getDurationFormattedAttribute()
    {
        return Date::parse($this->end_at)->diffForHumans($this->start_at, true);
    }

    public function getStartAtFormattedAttribute()
    {
        return Date::parse($this->start_at)->format('j. M');
    }

    public function getEndAtFormattedAttribute()
    {
        return Date::parse($this->end_at)->format('j. M Y');
    }

    public function getCoordinatesAttribute()
    {
        return $this->endDestinations
            ->first()
            ->vars()
            ->coordinates();
    }

    public function getImageAttribute()
    {
        // Cache image to avoid N+1 query problem
        // Eager loading via many intermediates is
        // more complicated
        return Cache::remember('offer_image_' . $this->id, 10, function () {
            $image = $this->endDestinations
                ->first()
                ->content()
                ->latest()
                ->whereType('photo')
                ->whereStatus(1)
                ->first();
            return $image ? $image->imagePreset('small_square') : '';
        });
    }

    public function getRouteAttribute()
    {
        return route('offer.show', [$this->id]);
    }
}
