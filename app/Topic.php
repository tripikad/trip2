<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Topic extends Model
{
    use Searchable;
    // Setup

    public $timestamps = false;

    public function content()
    {
        return $this->belongsToMany('App\Content');
    }

    public function SearchableAs()
    {
        return 'topics_index';
    }
    // V2

    public function vars()
    {
        return new V2TopicVars($this);
    }

    // V1

    public static function getNames()
    {
        return self::pluck('name', 'id')->sort();
    }
}
