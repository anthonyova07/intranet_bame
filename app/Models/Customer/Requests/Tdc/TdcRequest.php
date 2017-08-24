<?php

namespace Bame\Models\Customer\Requests\Tdc;

use Illuminate\Database\Eloquent\Model;

class TdcRequest extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intcuretdc';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeLastestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
