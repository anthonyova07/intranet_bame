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

    public function scopeLoans($query)
    {
        return $query->where('type', 'PRE');
    }

    public function scopeInvestments($query)
    {
        return $query->where('type', 'INV');
    }
}
