<?php

namespace Bame\Models\HumanResource\Vacant;

use Illuminate\Database\Eloquent\Model;

class Vacant extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranet_vacancies';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
