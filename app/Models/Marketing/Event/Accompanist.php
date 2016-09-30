<?php

namespace Bame\Models\Marketing\Event;

use Illuminate\Database\Eloquent\Model;

class Accompanist extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranet_event_accompanists';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
