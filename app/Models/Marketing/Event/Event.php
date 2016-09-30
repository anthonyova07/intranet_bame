<?php

namespace Bame\Models\Marketing\Event;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\Marketing\Event\Subscription\Subscription;
use Bame\Models\Marketing\Event\Subscription\Accompanist;

class Event extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranet_events';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dates = ['end_subscriptions', 'start_event'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function accompanists()
    {
        return $this->hasMany(Accompanist::class);
    }

    public function canSubscribe()
    {
        if ($this->limit_persons) {
            return $this->subscriptions
                ->where('is_subscribe', '1')
                ->count() < $this->number_persons;
        }

        return true;
    }

    public function userSubscription()
    {
        return $this->subscriptions
            ->where('username', session()->get('user'))
            ->first();
    }

    public function isSubscribe()
    {
        return (bool) $this->subscriptions
            ->where('username', session()->get('user'))
            ->where('is_subscribe', '1')
            ->count();
    }
}
