<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{

    public $timestamps = false;

    public function content()
    {
        return $this->belongsToMany('App\Content');
    }

    static function getNames($type)
    {
        return Topic::whereHas('content', function ($query) use ($type) {
            
            $query->whereType($type);
        
        })
        ->lists('name', 'id')
        ->sort();
    }

}
