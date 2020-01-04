<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viewable extends Model
{
    protected $fillable = ['viewable_id', 'viewable_type', 'count'];

    public $timestamps = false;
}

