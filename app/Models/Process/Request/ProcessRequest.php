<?php

namespace Bame\Models\Process\Request;

use Illuminate\Database\Eloquent\Model;

class ProcessRequest extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intreqpr';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeActiveOnly($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLastestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class, 'req_id');
    }

    public function status()
    {
        return $this->hasMany(Status::class, 'req_id');
    }

    public function attaches()
    {
        return $this->hasMany(Attach::class, 'req_id');
    }

    public function isApproved()
    {
        $approvals = $this->approvals;

        if ($approvals->count() > 0) {
            foreach ($approvals as $approval) {
                if ($approval->approved <> '1') {
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
        return !(bool) $this->approvals()->where('approved', '<>', '1')->get()->count();
    }

    public function getStatus()
    {
        $approvals = $this->approvals;

        $count_1 = $approvals->where('approved', '1')->count();
        $count_0 = $approvals->where('approved', '0')->count();

        if ($count_1 > 0 && $count_1 == $approvals->count()) {
            return '1';
        } else if ($count_0 > 0 && $count_0 == $approvals->count()) {
            return '0';
        } else {
            return '';
        }
    }
}
