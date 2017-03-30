<?php

namespace Bame\Models\Event\Subscription;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrevesub';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
