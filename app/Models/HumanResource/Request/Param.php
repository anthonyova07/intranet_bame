<?php

namespace Bame\Models\HumanResource\Request;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intreqprpa';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeActiveOnly($query)
    {
        return $query->where('is_active', true);
    }
}
