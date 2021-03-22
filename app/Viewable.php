<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viewable extends Model
{
    protected $table = 'viewables';

    protected $fillable = ['viewable_id', 'viewable_type', 'count'];

    //public bool $timestamps = false;

    public function usesTimestamps()
    {
        return false;
    }
}
