<?php

namespace Bame\Models\Customer\Requests\Tdc;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intcuretpa';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeActiveOnly($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDenails($query)
    {
        return $query->where('type', 'DEN');
    }
}
