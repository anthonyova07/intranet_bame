<?php

namespace Bame\Models\Process\ClosingCost;

use Illuminate\Database\Eloquent\Model;

class ClosingCost extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intproccos';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeLastestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
