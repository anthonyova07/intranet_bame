<?php

namespace Bame\Models\Security;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function scopeLastestFirst($query) {
        return $query->orderBy('created_at' , 'desc');
    }
}
