<?php namespace App;

use Illuminate\Database\Eloquent\Model;

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

    static function getNames($type)
    {
        
        return Cache::rememberForever("destination.names.$type", function() use ($type) {
        
            return Destination::whereHas('content', function ($query) use ($type) {
                    $query->whereType($type);
                })
                ->select('name', 'id')
                ->lists('name', 'id')
                ->transform(function ($item, $key) {
                    
                    $ancestors = Destination::find($key)->ancestorsAndSelf()->lists('name')->toArray();
                    return join(' › ', $ancestors);
                
                })
                ->sort();
        
        });
    
    }

}
