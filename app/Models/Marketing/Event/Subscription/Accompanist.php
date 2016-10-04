<?php

namespace Bame\Models\Marketing\Event\Subscription;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\Marketing\Event\Accompanist as AccompanistInfo;

class Accompanist extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranet_event_subscription_accompanists';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function accompanist()
    {
        return $this->belongsTo(AccompanistInfo::class);
    }
}
