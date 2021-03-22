<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterSent extends Model
{
    protected $table = 'newsletter_sents';

    //public bool $timestamps = false;

    public function usesTimestamps()
    {
        return false;
    }

    protected $dates = ['started_at', 'ended_at'];

    protected $appends = ['newsletter_type_num', 'sent_num', 'sending_num', 'subscriptions_num'];

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

    public function subscriptions_count()
    {
        return $this->subscriptions()->selectRaw('newsletter_type_id, count(*) as aggregate');
    }

    public function sent_count()
    {
        return $this->sent()->selectRaw('sent_id, count(*) as aggregate');
    }

    public function sending_count()
    {
        return $this->sent()
            ->selectRaw('sent_id, count(*) as aggregate')
            ->where('sending', 0);
    }

    public function newsletter_type_count()
    {
        return $this->newsletter_type()->selectRaw('count(*) as aggregate');
    }

    public function getNewsletterTypeNumAttribute()
    {
        return $this->getCountRelation('newsletter_type_count');
    }

    public function getSentNumAttribute()
    {
        return $this->getCountRelation('sent_count');
    }

    public function getSendingNumAttribute()
    {
        return $this->getCountRelation('sending_count');
    }

    public function getSubscriptionsNumAttribute()
    {
        return $this->getCountRelation('subscriptions_count');
    }

    private function getCountRelation($relation)
    {
        if (!array_key_exists($relation, $this->relations)) {
            $this->load($relation);
        }

        $related = $this->getRelation($relation);

        if ($related->count()) {
            $related = $related->first();
        } else {
            $related = null;
        }

        return $related ? (int) $related->aggregate : 0;
    }
}
