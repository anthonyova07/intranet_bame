<?php

namespace Bame\Http\Controllers\Cumplimiento\Cliente;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;
use Bame\Models\Cumplimiento\Cliente\Cumst;
use Bame\Http\Requests\Cumplimiento\Cliente\CumstFormRequest;
use Illuminate\Support\Facades\Redirect;
use DB;

class CumstController extends Controller
{
   
   public function index(Request $request)
    {

    If ($request->codigo  <> 0) {
           do_log('Busco el Cliente (' .$request->codigo . '  )');
    }       
    	
    $cliente = $request->codigo;
    $clientes = Cumst::orderBy('cuscun', 'asc')
    ->where('cuscun','=',$request->codigo)
    ->paginate(10);                
    return view('cumplimiento.cliente.index',["clientes"=>$clientes])->with('cliente', $cliente);        
    }  

   
    public function edit($id)
    {
        return view("cumplimiento.cliente.edit",["cliente"=>Cumst::findOrFail($id)]);
  
    }
    
    public function show($id)
    {
        return view("cumplimiento.cliente.show",["cliente"=>Cumst::findOrFail($id)]);
    }

    public function update(CumstFormRequest $request,$id)
    {
    	do_log('Actualizo el Cliente (' .$request->codigo . '  )');    	

        $cliente=Cumst::findOrFail($id);
        $cliente->cusln3=$request->get('Identificacion');
        $cliente->cusna1=$request->get('nombre');
        $cliente->cusfna=$request->get('primernombre');
        $cliente->cusfn2=$request->get('segundonombre');
        $cliente->cusln1=$request->get('primerapellido');
        $cliente->cusln2=$request->get('segundoapellido');
        $cliente->cusidn=$request->get('pasaporte');        
        $cliente->cusbdd=$request->get('dia');
        $cliente->cusbdm=$request->get('mes');
        $cliente->cusbdy=$request->get('anio');
        $cliente->update();
        return Redirect::to('cumplimiento/cliente');
    }

}
