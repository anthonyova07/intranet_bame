<?php

namespace Bame\Models\Cumplimiento\Cliente;
use Illuminate\Database\Eloquent\Model;

class Cumst extends Model
{
     protected $connection = 'ibs';

     protected $table='cumst';

     protected $primaryKey='cuscun';

     public $timestamps=false;   

     protected $fillable =[
            'cusln3',
            'cusna1',
            'cusfna',
            'cusfn2',
            'cusln1',
            'cusln2',
            'cusidn',
            'cusshn',
            'cusbdd',
            'cusbdm',
            'cusbdy'
     ];     
}