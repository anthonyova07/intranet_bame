<?php

namespace Bame\Models\Customer\Claim;

use Illuminate\Database\Eloquent\Model;

class Attach extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrclaatt';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function claim()
    {
        return $this->belongsTo(Claim::class, 'claim_id');
    }

    public function scopeLastestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function delete_attach()
    {
        $path = storage_path('app\\claims\\attaches\\' . $this->claim_id . '\\' . $this->file);

        if (file_exists($path)) {
            unlink($path);
        }
    }
}
