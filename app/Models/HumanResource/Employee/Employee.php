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

    public function scopeByUser($query, $user = null)
    {
        if ($user) {
            return $query->where('useremp', $user);
        }

        return $query->where('useremp', session('user'));
    }

    public function getOffice()
    {
        return session('user_info')->physicaldeliveryofficename[0];
    }

    public function getTitle($clean = true)
    {
        return $clean ? strtolower(trim(session('user_info')->getTitle())) : session('user_info')->getTitle();
    }

    public function isCallCenter()
    {
        return str_contains($this->getTitle(), 'call center');
    }

    public function isBusinessOfficer()
    {
        return str_contains($this->getTitle(), 'oficial') ||
            str_contains($this->getTitle(), 'ejecutivo') ||
            str_contains($this->getTitle(), 'supervisor') ||
            str_contains($this->getTitle(), 'gerente') ||
            str_contains($this->getTitle(), 'cajero') ||
            str_contains($this->getTitle(), 'negocio');
    }

    public static function getChannel($description = false)
    {
        if (session()->has('employee')) {
            $employee = session('employee');

            $office = $employee->getOffice();

            if ($employee->isBusinessOfficer()) {
                if ($description) {
                    return get_office_code($office, $description);
                }

                return get_channel_officer(get_office_code($office));
            }

            if ($employee->isCallCenter()) {
                return $description ? 'Call Center Interno':'CCI';
            }

            return $description ? 'Empleado':'EMP';
        }

        return $description ? 'Call Center Externo':'CCE';
    }
}
