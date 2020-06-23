<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollResult extends Model
{
    protected $table = 'poll_results';
    public $timestamps = false;

    public function poll()
    {
        return $this->belongsTo('App\Poll', 'poll_id', 'id');
    }

}
