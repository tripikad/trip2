<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $dates = ['created_at', 'updated_at'];

    protected $with = ['plan'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function plan()
    {
        return $this->hasOne('App\SubscriptionPlan', 'id', 'plan_id');
    }
}

