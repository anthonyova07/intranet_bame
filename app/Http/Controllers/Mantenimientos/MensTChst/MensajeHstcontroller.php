<?php

namespace Bame\Http\Controllers\Mantenimientos\MensTChst;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use  Bame\Models\Mantenimientos\MensTChst\MensajeHst;
use DB;

class MensajeHstcontroller extends Controller
{
    public function index(Request $request){ 

       		if ($request){
        		do_log('Consultó Historico de Mensajes de Estados de Cuetnas TC');      		

      			$mensajeshst = MensajeHst::orderBy('cdmsg_intm', 'asc')         			
       			->paginate(10);
       			return view('mantenimientos.menstchst.index',["mensajeshst"=>$mensajeshst]);        
    	    }       
	}   

	public function reportehistoricomsg($codigo){ 

       	  $mensajeshst = MensajeHst::orderBy('fecha_intm', 'desc')         			
      		->where('cdmsg_intm','=',$codigo)  
       		->paginate(10);
       		return view('mantenimientos.menstchst.index',["mensajeshst"=>$mensajeshst]);            	    
	}  	

}
