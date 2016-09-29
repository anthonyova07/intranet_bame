<?php

namespace Bame\Models\Marketing\Event;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranet_events';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dates = ['end_subscriptions', 'start_event'];
}
