<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['user_id_from', 'user_id_to', 'body'];

    protected $appends = ['title', 'body_filtered'];

    public function fromUser()
    {
        return $this->belongsTo('App\User', 'user_id_from');
    }

    public function toUser()
    {
        return $this->belongsTo('App\User', 'user_id_to');
    }

    public function withUser()
    {
        return $this->belongsTo('App\User', 'user_id_with');
    }

    public function getTitleAttribute()
    {
        return str_limit($this->attributes['body'], 70);
    }

    public function getBodyAttribute($value)
    {
        return $value;
    }

    public function getBodyFilteredAttribute()
    {
        return Main::getBodyFilteredAttribute($this);
    }
}
