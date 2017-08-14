<?php

namespace Bame\Models\Event;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\Department\Department;
use Bame\Models\Event\Subscription\Subscription;
use Bame\Models\Event\Subscription\Accompanist;

class Event extends Model
{
    use Department;

    protected $connection = 'ibs';

    protected $table = 'intrevents';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dates = ['end_subscriptions', 'start_event', 'end_event'];

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
            $totalPersons = $this->subscriptions
                                ->where('is_subscribe', '1')
                                ->count();
            $totalAccompanists = $this->accompanists
                                    ->where('is_subscribe', '1')
                                    ->count();

            $totalSubscriptions = $totalPersons + $totalAccompanists;

            if ($this->limit_accompanists) {
                $totalUserAccompanist = $this->accompanists
                                            ->where('owner', session()->get('user'))
                                            ->where('is_subscribe', '1')
                                            ->count();

                if ($totalUserAccompanist >= (int) $this->number_accompanists) {
                    return false;
                }
            }

            return $totalSubscriptions < (int) $this->number_persons;
        }

        return true;
    }

    public function userSubscription()
    {
        return $this->subscriptions
            ->where('username', session()->get('user'))
            ->first();
    }

    public function accompanistSubscription($accompanist_id)
    {
        return $this->accompanists
            ->where('owner', session()->get('user'))
            ->where('accompanist_id', $accompanist_id)
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
