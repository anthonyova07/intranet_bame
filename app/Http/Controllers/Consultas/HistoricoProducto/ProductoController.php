<?php

namespace Bame\Http\Controllers\Consultas\HistoricoProducto;

use Illuminate\Http\Request;

use  Bame\Models\Consultas\HistProd\Producto;

use Bame\Http\Requests;

use Bame\Http\Controllers\Controller;

use DB;

class ProductoController extends Controller
{
    public function index(Request $request){

    	If ($request->codigo  <> 0) {
        do_log('Consultó Historico de Producto el Cliente (' .$request->codigo . ' )');
      }          	     

      $productos = Producto::orderBy('hiscor', 'asc')
       ->where('hiscun','=',$request->codigo)
       ->paginate(10);           
       return view('consultas.historicoproducto.index',["productos"=>$productos])->with('cliente',$request->codigo);        
    }  
   

    public function reportepdf($cliente) {     

      If ($cliente > 0) {  
         do_log('Genereacion en PDF de los productos del  Cliente (' .$cliente . ' )');
      }  
         
      $productospdf = Producto::orderBy('hiscor', 'asc')
      ->where('hiscun','=',$cliente)
      ->get();           
      return view('pdfs.hisprod.show',["productospdf"=>$productospdf]);                   
    }
}
