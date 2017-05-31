<?php

namespace Bame\Models\Consultas\HistProd;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
   protected $connection = 'ibs';

     protected $table='vwhisttra';

     protected $primaryKey='';

     public $timestamps=false;       
    
}
