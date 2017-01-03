<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // Setup

    protected $fillable = ['user_id_from', 'user_id_to', 'body'];

    protected $appends = ['title', 'body_filtered'];

    // Relations

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

    // V2

    public function vars()
    {
        return new V2MessageVars($this);
    }

    // V1

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
