<?php

namespace Bame\Models\Customer\Claim;

use Illuminate\Database\Eloquent\Model;

class CtDc extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranet_claim_ct_dc';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeActiveOnly($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVisaOnly($query)
    {
        return $query->where('type', 'VISA');
    }
}
