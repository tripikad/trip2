<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    protected $table = 'flags';

    protected $fillable = ['flaggable_type', 'flaggable_id', 'flag_type'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function flaggable()
    {
        return $this->morphTo();
    }
}
