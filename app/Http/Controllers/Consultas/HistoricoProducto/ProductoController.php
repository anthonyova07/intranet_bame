<?php

namespace Bame\Http\Controllers\Consultas\HistoricoProducto;

use Illuminate\Http\Request;

use  Bame\Models\Consultas\HistProd\Producto;

use Bame\Http\Requests;

use Bame\Http\Controllers\Controller;

class ProductoController extends Controller
{
    public function index(Request $request)
    {

    	If ($request->codigo  <> 0) {
           do_log('Consultó Historico de Producto el Cliente (' .$request->codigo . ' )');
        }       
    	
        $productos = Producto::orderBy('hiscor', 'asc')
        ->where('hiscun','=',$request->codigo)
        ->orderBy('hiscor','asc')    
        ->get();                    
        return view('consultas.historicoproducto.index',["productos"=>$productos]);        
    }  

}
