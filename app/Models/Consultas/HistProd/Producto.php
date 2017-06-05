<?php

namespace Bame\Models\Consultas\HistProd;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
     protected $connection = 'ibs';

     protected $table='vwhistpro';

     protected $primaryKey='';

     public $timestamps=false;   

     protected $fillable =[
            'hiscun',
            'hisacc',
            'hisacd',
            'hismto',
            'hissts',
            'hisodd',
            'hisodm',
            'hisody',
            'hisccy',
            'hiscor',
            'hislpd',
            'hislpm',
            'hislpy'
     ];



     public function Balance($with_format = true)
    {
        if ($with_format) {
            return number_format(clear_str($this->hismto), 2);
        }

        return clear_str($this->hismto);
    }

      public function TipoProducto()
    {
       $mTipo="Cuenta Corriente";

       If ($this->hisacd == '10') {
           $mTipo = "Prestamo";
       }        

       If ($this->hisacd == '11') {
           $mTipo = "Deposito Plazo";
       }        

       If ($this->hisacd == '04') {
           $mTipo = "Cuenta de Ahorro";
       }       
        return ($mTipo);
    }
 
}
    
