<?php

namespace App;

use Cache;
use Baum;

class Destination extends Baum\Node
{
    public $timestamps = false;

    public function content()
    {
        return $this->belongsToMany('App\Content');
    }

    public function flags()
    {
        return $this->morphMany('App\Flag', 'flaggable');
    }

    public function usersHaveBeen()
    {
        return $this->flags->where('flag_type', 'havebeen');
    }

    public function usersWantsToGo()
    {
        return $this->flags->where('flag_type', 'wantstogo');
    }

    public static function getNames()
    {
        return Cache::rememberForever('destination.names', function () {

            return Destination::select('name', 'id')
                ->lists('name', 'id')
                ->transform(function ($item, $key) {

                    $ancestors = Destination::find($key)->ancestorsAndSelf()->lists('name')->toArray();

                    return implode(' › ', $ancestors);

                })
                ->sort();

        });
    }
}
