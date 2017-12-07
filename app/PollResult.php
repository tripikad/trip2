<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollResult extends Model
{
    protected $fillable = ['field_id', 'user_id', 'result'];

    protected $table = 'poll_results';

    protected $primaryKey = 'poll_result_id';

    public $timestamps = false;

    public function poll()
    {
        return $this->belongsTo('App\Poll', 'poll_id', 'id');
    }

    public function poll_field()
    {
        return $this->belongsTo('App\PollField', 'field_id', 'field_id');
    }
}
