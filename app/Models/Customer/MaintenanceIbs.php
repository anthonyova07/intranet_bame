<?php

namespace Bame\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class MaintenanceIbs extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intmaiibs';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dateFormat = 'Y-m-d H:i:s';

    public function itc_dir_one()
    {
        return $this->hasOne(MaintenanceItc::class, 'parent_id', 'id')->where('dir_type', 1);
    }

    public function itc_dir_two()
    {
        return $this->hasOne(MaintenanceItc::class, 'parent_id', 'id')->where('dir_type', 2);
    }
}
