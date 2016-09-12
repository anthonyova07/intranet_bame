<?php

namespace Bame\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function scopeLastestFirst($query) {
        return $query->orderBy('id' , 'desc');
    }
}
