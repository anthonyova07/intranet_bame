@extends('layouts.master')

@section('title', 'Mensajes - Estados de Cuentas TC')

@section('page_title', 'Editar Mensaje Estados de Cuentas TC')

@if (can_not_do('mensaje_estado_tc'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')


    @if (count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
             </ul>
        </div>
    @endif


    <div class="row">
        <div class="col-xs-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">                                                                       

                         <form method="post" action="{{ route('mantenimientos.menstc.update', $mensaje->cdmsg_intm) }}" id="form">                                          
                          
                        
                        <div class="row">

                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label for="nombre">Codigo</label>
                                    <input type="text" name="codigo" readonly class="form-control" value="{{$mensaje->cdmsg_intm}}" placeholder="Codigo...">
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="mensaje1">Linea 1</label>
                                    <input type="text" name="mensaje1" maxlength="60" class="form-control" value="{{trim($mensaje->d3msg_intm)}}" placeholder="Mensaje 1...">
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="mensaje2">Linea 2</label>
                                    <input type="text" name="mensaje2" maxlength="60" class="form-control" value="{{trim($mensaje->d4msg_intm)}}" placeholder="Mensaje 2...">
                                </div>
                            </div>                           

                            <div class="col-xs-12">
                                <strong>

                                 El mensaje en los estados de cuentas aparecen en la parte inferior derecha, en dos líneas de 60 caracteres cada una
                                 por favor redactar el mismo de forma que se vea acorde en las dos líneas

                                 </strong>
                            </div>
                            
                        </div>

                        {{ method_field('PUT') }}
                        {{ csrf_field() }} 
                      
                         <br/>                         
                        
                        <a class="btn btn-info btn-xs"href="{{route('mantenimientos.menstc.index')}}"><i class="fa fa-arrow-left"></i> Atrás</a>                        

                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>                                                     

                    </form>
                </div>
            </div>
        </div>
    </div>     

@endsection
