<?php

namespace Bame\Models\Extranet;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intextbusi';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function users()
    {
        return $this->hasMany(Users::class, 'id', 'busi_id');
    }

    public function getRolesArray()
    {
        return $this->roles ? explode(',', $this->roles) : [];
    }

    public function hasRole($role)
    {
        return in_array($role, $this->getRolesArray());
    }
}
