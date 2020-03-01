<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterLetterContent extends Model
{
    // Setup

    protected $dates = ['created_at', 'updated_at'];

    public function vars()
    {
        return new NewsletterLetterContentVars($this);
    }

    // Relations
}
