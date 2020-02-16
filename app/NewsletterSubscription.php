<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscription extends Model
{
    // Setup

    protected $dates = ['last_sent_at', 'created_at', 'updated_at'];

    // Relations

    public function sents()
    {
        return $this->hasMany('App\NewsletterSentSubscriber', 'subscription_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function newsletter_type()
    {
        return $this->hasOne('App\NewsletterType', 'id', 'newsletter_type_id');
    }
}
