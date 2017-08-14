<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterType extends Model
{
    // Setup

    protected $dates = ['last_sent_at', 'send_at', 'created_at', 'updated_at'];

    // Relations
}
