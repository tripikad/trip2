<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topics';

    public $timestamps = false;

    public function content()
    {
        return $this->belongsToMany('App\Content');
    }

    public function vars()
    {
        return new TopicVars($this);
    }

    public static function getNames()
    {
        return self::pluck('name', 'id')->sort();
    }
}
