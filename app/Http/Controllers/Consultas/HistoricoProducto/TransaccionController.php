<?php

namespace Bame\Http\Controllers\Consultas\HistoricoProducto;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use  Bame\Models\Consultas\HistProd\Transaccion;

use DB;


class TransaccionController extends Controller
{

	public function reportetrans($cuenta){

          do_log('Consultó Transacciones del Producto No. (' .$cuenta . ' )');        
          
          $transacciones = Transaccion::orderBy('tracor', 'asc')
          ->where('traacc','=',$cuenta)  
          ->paginate(10);
          return view('consultas.historicoproducto.trans',["transacciones"=>$transacciones])->with('cuenta',$cuenta);              
          
    }   

    public function reportetranspdf($producto)   
     {     
          $transaccionespdf = Transaccion::orderBy('tracor', 'asc')
          ->where('traacc','=',$producto)
           ->get();           
          return view('pdfs.histrans.show',["transaccionespdf"=>$transaccionespdf]);      
    }

   
}
