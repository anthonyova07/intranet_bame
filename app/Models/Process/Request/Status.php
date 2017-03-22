<?php

namespace Bame\Models\Process\Request;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intreqpres';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopegetLastStatus($query)
    {
        return $this->orderBy('created_at', 'desc')->take(1);
    }
}
