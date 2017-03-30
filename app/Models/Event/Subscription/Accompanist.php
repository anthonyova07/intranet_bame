<?php

namespace Bame\Models\Event\Subscription;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\Event\Accompanist as AccompanistInfo;

class Accompanist extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrevsuba';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function accompanist()
    {
        return $this->belongsTo(AccompanistInfo::class);
    }
}
