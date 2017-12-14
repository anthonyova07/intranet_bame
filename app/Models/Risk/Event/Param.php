<?php

namespace Bame\Models\Risk\Event;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrievepa';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeActiveOnly($query)
    {
        return $query->where('is_active', true);
    }
}