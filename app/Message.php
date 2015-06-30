<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    public function from()
    {
        return $this->belongsTo('App\User', 'user_id_from');
    }

    public function to()
    {
        return $this->belongsTo('App\User', 'user_id_to');
    }

}
