<?php

namespace Bame\Models\Marketing\Event\Subscription;

use Illuminate\Database\Eloquent\Model;

class Accompanist extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranet_event_subscription_accompanists';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
