<?php

namespace Bame\Models\FinancialCalculations;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intficapar';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
