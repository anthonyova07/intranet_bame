<?php

namespace Bame\Http\Controllers\Mantenimientos\MensTC;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use  Bame\Models\Mantenimientos\MensTC\Mensaje;
use Bame\Http\Requests\mantenimientos\Menstc\MensajeFormRequest;
use DB;

use Carbon\Carbon;

class Mensajecontroller extends Controller
{
    public function index(Request $request){    	      		

       		if ($request){
        		do_log('Consultó Mensajes de Estados de Cuetnas TC');      		

      			$mensajes = Mensaje::orderBy('cdmsg_intm', 'asc')
       			->paginate(10);
       			return view('mantenimientos.menstc.index',["mensajes"=>$mensajes]);        
    	    }       
	}   

	public function edit($id)
    {
        return view("mantenimientos.menstc.edit",["mensaje"=>Mensaje::findOrFail($id)]);
    }  

	public function update(MensajeFormRequest $request,$id)	
    {    	
        $mensaje=Mensaje::findOrFail($id);
        $mensaje->d3msg_intm=trim($request->get('mensaje1'));   
        $mensaje->d4msg_intm=trim($request->get('mensaje2'));   
        $mensaje->usuar_intm=session()->get('user');     
        $mensaje->fecha_intm= Carbon::now();
        $mensaje->update();

       return redirect(route('mantenimientos.menstc.index'));
    }

    public function show($id)
    {
        return view("mantenimientos.menstc.show",["mensaje"=>Mensaje::findOrFail($id)]);
    }
  
}


	
   