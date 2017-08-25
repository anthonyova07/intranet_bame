<?php

namespace Bame\Models\Mantenimientos\MensTC;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $connection = 'itc';

    protected $table='intm0016fm';

    protected $primaryKey='cdmsg_intm';

    public $incrementing = false;

    public $timestamps=false;   

    protected $fillable =[            
            'd3msg_intm',
            'd4msg_intm',            
            'usuar_intm',
            'fecha_intm'
    ];     
}
