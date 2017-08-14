<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscription extends Model
{
    // Setup

    protected $dates = ['last_sent_at', 'created_at', 'updated_at'];

    // Relations
}
