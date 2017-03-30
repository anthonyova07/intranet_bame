<?php

namespace Bame\Models\Customer\Claim;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrclapar';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeActiveOnly($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeTdcOnly($query)
    {
        return $query->where('type', 'TDC');
    }

    public function scopeOrderByDescription($query)
    {
        return $query->orderBy('description', 'asc');
    }
}
