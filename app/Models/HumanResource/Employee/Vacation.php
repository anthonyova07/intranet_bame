<?php

namespace Bame\Models\HumanResource\Employee;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intempvacs';

    // protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = false;

    public function scopeExist($query, $year)
    {
        return $query->where('year', $year);
    }
}
