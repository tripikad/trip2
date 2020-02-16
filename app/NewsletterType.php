<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class NewsletterType extends Model
{
    // Setup

    protected $dates = ['last_sent_at', 'send_at', 'created_at', 'updated_at'];

    // Relations

    public function all_subscriptions()
    {
        return $this->hasMany('App\NewsletterSubscription', 'newsletter_type_id', 'id');
    }

    public function subscriptions()
    {
        return $this->all_subscriptions()
            ->where('active', 1)
            ->orderBy('destination_id', 'desc');
    }

    public function user_subscriptions()
    {
        return $this->subscriptions()->where('user_id', request()->user()->id ?? null);
    }

    public function newsletter_visible_content()
    {
        $date_today = Carbon::now()->format('Y-m-d');

        return $this->hasMany('App\NewsletterLetterContent', 'newsletter_type_id', 'id')
            ->where(function ($query) use ($date_today) {
                $query->whereNull('visible_from')->orWhereDate('visible_from', '<=', $date_today);
            })
            ->where(function ($query) use ($date_today) {
                $query->whereNull('visible_to')->orWhereDate('visible_to', '>=', $date_today);
            })
            ->orderBy('sort_order', 'asc');
    }
}
