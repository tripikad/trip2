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

    public static function getNames()
    {
        return self::lists('name', 'id')->sort();
    }
}
