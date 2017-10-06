<?php

namespace Bame\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class MaintenanceIbs extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intmaiibs';

    protected $primaryKey = 'id';

    public $incrementing = false;

    // protected $dates = ['approvdate'];

    public $timestamps = false;

    // protected $dateFormat = 'Y-m-d H:i:s';

    public function itc_dir_one()
    {
        return $this->hasOne(MaintenanceItc::class, 'parent_id', 'id')->where('dir_type', 1);
    }

    public function itc_dir_two()
    {
        return $this->hasOne(MaintenanceItc::class, 'parent_id', 'id')->where('dir_type', 2);
    }

    public function scopeLastest($query)
    {
        // $this->dateFormat = 'Y-m-d H:i:s';

        return $query->orderBy('created_at', 'desc')->orderBy('isapprov', 'asc');
    }

    public function scopeOnlyPendingForApprove($query)
    {
        return $query->where('isapprov', false)->orderBy('created_at', 'desc');
    }
}
