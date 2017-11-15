<?php

namespace Bame\Models\Risk\Event;

use Bame\Models\Risk\Event\Param;
use Illuminate\Database\Eloquent\Model;

class RiskEvent extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intriskeve';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeLastestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function business_line()
    {
        return $this->belongsTo(Param::class, 'busineline');
    }

    public function event()
    {
        return $this->belongsTo(Param::class, 'event_type');
    }

    public function currency_type()
    {
        return $this->belongsTo(Param::class, 'curre_type');
    }

    public function branch_office()
    {
        return $this->belongsTo(Param::class, 'bran_offic');
    }

    public function area_department()
    {
        return $this->belongsTo(Param::class, 'area_depar');
    }

    public function distribution_channel()
    {
        return $this->belongsTo(Param::class, 'dist_chann');
    }

    public function pro()
    {
        return $this->belongsTo(Param::class, 'process');
    }

    public function subpro()
    {
        return $this->belongsTo(Param::class, 'subprocess');
    }

    public function loss()
    {
        return $this->belongsTo(Param::class, 'loss_type');
    }
}
