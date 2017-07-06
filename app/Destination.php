<?php

namespace App;

use Baum;
use Cache;
use Cviebrock\EloquentSluggable\Sluggable as Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers as SlugHelper;

class Destination extends Baum\Node
{
    use Sluggable, SlugHelper;

    public $timestamps = false;

    public function content()
    {
        return $this->belongsToMany('App\Content');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function vars()
    {
        return new V2DestinationVars($this);
    }

    public function flags()
    {
        return $this->morphMany('App\Flag', 'flaggable');
    }

    // Also present in V2DestinationVars

    public function usersHaveBeen()
    {
        return $this->flags->where('flag_type', 'havebeen');
    }

    public function usersWantsToGo()
    {
        return $this->flags->where('flag_type', 'wantstogo');
    }

    // ...

    public function getPopular()
    {
        return Cache::remember('popular.destinations.root'.$this->id, config('cache.destination.getPopular'), function () {
            return Destination::find($this->id)
                ->descendantsAndSelf()
                ->with('flags')
                ->get()
                ->transform(function ($item) {
                    $item->attributes['usersHaveBeen'] = $item->usersHaveBeen()->count();
                    $item->attributes['usersWantsToGo'] = $item->usersWantsToGo()->count();
                    $item->attributes['interestTotal'] = $item->attributes['usersHaveBeen'] + $item->attributes['usersWantsToGo'];

                    return $item;
                });
        });
    }

    public static function getNames()
    {
        return Cache::rememberForever('destination.names', function () {
            return collect(Main::collectionAsSelect(
                [],
                ' › ',
                Destination::select('name', 'id', 'parent_id')->get()
            ))->sort();
        });
    }

    public function getDestinationParent()
    {
        if ($this) {
            return $this->parent()->first();
        }
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }
}
