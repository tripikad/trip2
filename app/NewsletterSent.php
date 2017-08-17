<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterSent extends Model
{
    // Setup

    public $timestamps = false;
    protected $dates = ['started_at', 'ended_at'];

    // Relations

    public function subscriptions()
    {
        return $this->hasMany('App\NewsletterSubscription', 'newsletter_type_id', 'id')->where('active', 1);
    }

    public function sent()
    {
        return $this->hasMany('App\NewsletterSentSubscriber', 'sent_id', 'id');
    }

    public function newsletter_type()
    {
        return $this->hasOne('App\NewsletterType', 'id', 'newsletter_type_id');
    }

    public function destination()
    {
        return $this->hasOne('App\Destination', 'id', 'destination_id');
    }
}
