<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterSentSubscriber extends Model
{
  // Setup

  protected $dates = ['started_at', 'ended_at'];

  // Relations

  public function sent()
  {
    return $this->hasOne('App\NewsletterSent', 'id', 'sent_id');
  }

  public function user()
  {
    return $this->hasOne('App\User', 'id', 'user_id');
  }

  public function subscription()
  {
    return $this->hasOne('App\NewsletterSubscription', 'id', 'subscription_id');
  }
}
