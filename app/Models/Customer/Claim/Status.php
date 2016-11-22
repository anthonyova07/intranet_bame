<?php

namespace Bame\Models\Customer\Claim;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranet_claim_statuses';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function statuses()
    {
        return $this->belongsTo(Claim::class, 'claim_id');
    }

    public function scopeLastestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
