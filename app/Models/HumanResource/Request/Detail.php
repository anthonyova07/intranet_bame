<?php

namespace Bame\Models\HumanResource\Request;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intreqrhde';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dates = [
        'perdatfrom',
        'perdatto',
        'perdatfror',
        'perdattor',
        'vacdatfror',
        'vacdattor',
    ];

    public function scopeLastestFirst($query)
    {
        return $this->orderBy('created_at', 'desc');
    }

    public function history()
    {
        return $this->hasMany(ReintegrateHistory::class, 'detail_id')->orderBy('created_at', 'desc');
    }

    public function scopeByReqIds($query, $request_ids)
    {
        $query->whereIn('req_id', $request_ids);
    }

    public function scopeByReqIdsAndCodeReason($query, $request_ids, $code)
    {
        return $query->byReqIds($request_ids)->where('codeforabs', $code);
    }

    public function scopeCurrentYear($query)
    {
        $year = datetime()->format('Y');

        return $query->where('created_at', '>=', $year . '-01-01 00:00:00')
            ->where('created_at', '<=', $year . '-12-31 23:59:59');
    }

    public function scopeBetweenDate($query, $date)
    {
        return $query->where('vacdatfrom', '<=', $date)->where('vacdatto', '>', $date);
    }
}
