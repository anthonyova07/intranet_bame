<?php

namespace Bame\Models\Event;

use Illuminate\Database\Eloquent\Model;

class Accompanist extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intreveaco';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
