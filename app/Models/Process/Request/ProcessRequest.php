<?php

namespace Bame\Models\Process\Request;

use Illuminate\Database\Eloquent\Model;

class ProcessRequest extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intreqpr';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeActiveOnly($query)
    {
        return $query->where('is_active', true);
    }
}
