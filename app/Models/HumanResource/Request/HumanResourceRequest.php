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

    public function getStatus()
    {
        $approvals = $this->approvals;

        $count_1 = $approvals->where('approved', '1')->count();
        $count_0 = $approvals->where('approved', '0')->count();

        if ($count_1 > 0 && $count_1 == $approvals->count()) {
            return '1';
        } else if ($count_0 > 0 && $count_0 == $approvals->count()) {
            return '0';
        } else {
            return '';
        }
    }
}
