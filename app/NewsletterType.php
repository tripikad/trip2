<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterType extends Model
{
    // Setup

    protected $dates = ['last_sent_at', 'send_at', 'created_at', 'updated_at'];

    // Relations

    public function subscriptions()
    {
        return $this->hasMany('App\NewsletterSubscription', 'newsletter_type_id', 'id')->where('active', 1);
    }

    public function user_subscriptions()
    {
        return $this->subscriptions()->where('user_id', request()->user()->id ?? null);
    }
}
