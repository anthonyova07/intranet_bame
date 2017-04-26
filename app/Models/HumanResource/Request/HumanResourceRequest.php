<?php

namespace Bame\Models\HumanResource\Request;

use Illuminate\Database\Eloquent\Model;

class HumanResourceRequest extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intreqrh';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeActiveOnly($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLastestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function detail()
    {
        return $this->hasOne(Detail::class, 'req_id');
    }
}
