<?php

namespace Bame\Models\Marketing\FAQs;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrafaqth';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
