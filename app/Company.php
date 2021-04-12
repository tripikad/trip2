<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable as Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers as SlugHelper;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use Sluggable, SlugHelper;

    protected $table = 'companies';

    protected $fillable = ['name'];

    protected $dates = ['created_at', 'updated_at'];

    protected $appends = [
        'showRoute'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function user()
    {
        return $this->hasOne('App\User', 'company_id', 'id');
    }

    public function travelOffers()
    {
        return $this->hasMany('App\TravelOffer');
    }

    public function activeTravelOffers()
    {
        return $this->travelOffers()
            ->where('active', true)
            ->where('end_date', '>=', Carbon::today()->toDateString());
    }

    public function getShowRouteAttribute()
    {
        return route('company.profile.public', ['slug' => $this->slug]);
    }
}
