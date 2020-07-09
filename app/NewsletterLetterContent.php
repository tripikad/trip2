<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterLetterContent extends Model
{
    protected $table = 'newsletter_letter_contents';

    protected $dates = ['created_at', 'updated_at'];

    public function vars()
    {
        return new NewsletterLetterContentVars($this);
    }

    // Relations
}
