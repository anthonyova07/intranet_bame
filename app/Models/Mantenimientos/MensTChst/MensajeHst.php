<?php

namespace Bame\Models\Mantenimientos\MensTChst;

use Illuminate\Database\Eloquent\Model;

class MensajeHst extends Model
{
    protected $connection = 'itc';

    protected $table='intm0016fmhst';

    protected $primaryKey='cdmsg_intm';

    public $incrementing = false;

    public $timestamps=false;   

    protected $fillable =[
            'd3msg_intm',
            'd4msg_intm',              
            'fecha_intm',
            'usuar_intm'
    ];     
}