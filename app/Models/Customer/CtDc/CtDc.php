<?php

namespace Bame\Models\Customer\CtDc;

use Illuminate\Database\Eloquent\Model;

class CtDc extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranet_ct_dc';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
