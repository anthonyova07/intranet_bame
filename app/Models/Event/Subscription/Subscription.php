<?php

namespace Bame\Models\Event\Subscription;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranet_event_subscriptions';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
