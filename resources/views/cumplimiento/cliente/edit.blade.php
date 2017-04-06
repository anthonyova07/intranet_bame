@extends('layouts.master')

@section('title', 'Mantenimiento Cliente')

@section('page_title', 'Mantenimiento de Cliente ')

@if (can_not_do('cliente_ibs'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif
@section('contents') 

<div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                
                <div class="panel-heading">
                    <h3 class="panel-title"> Cliente: {{$cliente->cusna1}}</h3>
                </div>

            @if (count($errors)>0)
			   <div class="alert alert-danger">
				    <ul>
				   		@foreach ($errors->all() as $error)
					   		<li>{{$error}}</li>
						@endforeach
					</ul>
				</div>
			@endif

			{!!Form::model($cliente,['method'=>'PATCH','route'=>['cumplimiento.cliente.update',$cliente->cuscun]])!!}
            {{Form::token()}}

                <div class="panel-body">
                  <form method="PATCH" action="{{route('cumplimiento.cliente.update',$cliente->cuscun) }}" id="form">
                    
                    <div class="row">                        
                        <div class="col-xs-3">                            
                            <label for="identificacion">Identificacion</label>
            				<input type="text" name="Identificacion" class="form-control" value="{{$cliente->cusln3}}">

                        </div>  

                        <div class="col-xs-3">                            
                            <label for="nombre">Nombre Completo</label>
            				<input type="text" name="nombre" class="form-control" value="{{$cliente->cusna1}}">

                        </div>                                   
                    </div>                    

                    <br>	

                    <div class="row">                        
                        <div class="col-xs-3">                            
                            <label for="primernombre">Primer Nombre</label>
            				<input type="text" name="primernombre" class="form-control" value="{{$cliente->cusfna}}">

                        </div>  

                        <div class="col-xs-3">                            
                            <label for="segundonombre">Segundo Nombre</label>
            				<input type="text" name="segundonombre" class="form-control" value="{{$cliente->cusfn2}}">

                        </div>                                   
                    </div>  

                    <br>

                    <div class="row">                        
                        <div class="col-xs-3">                            
                            <label for="primerapellido">Primer Apellido</label>
            				<input type="text" name="primerapellido" class="form-control" value="{{$cliente->cusln1}}">

                        </div>  

                        <div class="col-xs-3">                            
                            <label for="segundoapellido">Segundo Apellido</label>
            				<input type="text" name="segundoapellido" class="form-control" value="{{$cliente->cusln2}}">

                        </div>                                   
                    </div>     

                    <br>

                    <div class="row">                        
                        
                        <div class="col-xs-3">                            
                            <label for="pasaporte">PasaPorte</label>
            				<input type="text" name="pasaporte" class="form-control" value="{{$cliente->cusidn}}">
                        </div>  

                        <div class="col-xs-3">                            
                            <label for="nombrecorto">Nombre Corto</label>
            				<input type="text" name="nombrecorto" class="form-control" value="{{$cliente->cusshn}}">
                        </div>        	

                    </div>       

                    <div class="row">                        
                        
                        <div class="col-xs-1">                            
                            <label for="dia">Dia</label>
            				<input type="text" name="dia" class="form-control" value="{{$cliente->cusbdd}}">
                        </div>  

                       <div class="col-xs-1">                            
                            <label for="mes">Mes </label>
            				<input type="text" name="mes" class="form-control" value="{{$cliente->cusbdm}}">
                        </div>      

                        <div class="col-xs-1">                            
                            <label for="anio">Año </label>
            				<input type="text" name="anio" class="form-control" value="{{$cliente->cusbdy}}">
                        </div>                         

                    </div>      
                    
                    <a class="btn btn-info btn-xs" href="{{ URL::previous() }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                    <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>	                    

                {!!Form::close()!!}	  
                </div>
            </div>


        </div>


    </div>
@endsection