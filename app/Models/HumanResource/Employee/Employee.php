<?php

namespace Bame\Models\HumanResource\Employee;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrhemplo';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dates = [];

    public function department()
    {
        return $this->hasOne(Param::class, 'id', 'id_dep');
    }

    public function position()
    {
        return $this->hasOne(Param::class, 'id', 'id_pos');
    }

    public function supervisor()
    {
        return $this->hasOne(Param::class, 'id', 'id_sup');
    }

    public function supervisor_emp()
    {
        return $this->hasOne(Employee::class, 'id_pos', 'id_sup');
    }

    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'id_sup', 'id_pos');
    }

    public function scopeByUser($query, $user = null)
    {
        if ($user) {
            return $query->where('useremp', $user);
        }

        return $query->where('useremp', session('user'));
    }

    public function isSupervisor()
    {
        return (bool) $this->subordinates->count();
    }

    public function getSubordinatesUsers()
    {
        return $this->subordinates->pluck('useremp')->toArray();
    }
}
