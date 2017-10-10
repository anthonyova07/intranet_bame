<?php

namespace Bame\Models\Customer\Requests\Tdc;

use Illuminate\Database\Eloquent\Model;
use Bame\Models\Customer\Requests\Tdc\TdcRequest;

class CustomerProcessed extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intcuretpr';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeLastestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByIdentification($query, $identification)
    {
        return $query->where('identifica', $identification);
    }

    public function denail()
    {
        return $this->belongsTo(Param::class, 'denail_id', 'id')->where('type', 'DEN');
    }

    public function hasRequestCreated()
    {
        return $this->reqnumber != null && strlen($this->reqnumber) > 1;
    }

    public function isBlack()
    {
        return $this->is_black == 1;
    }

    public function hasDenail()
    {
        return $this->denail_id != null && strlen($this->denail_id) > 1;
    }

    public function isRequestDeleted()
    {
        if ($this->hasRequestCreated()) {
            $tdc_req = TdcRequest::byNumber($this->reqnumber)->first();

            if ($tdc_req) {
                return $tdc_req->isDeleted();
            }
        }

        return false;
    }
}
