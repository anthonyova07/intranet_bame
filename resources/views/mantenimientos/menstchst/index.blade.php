@extends('layouts.master')

@section('title', 'Historico de Mensajes Estados de TC')

@section('page_title', 'Historico de Mensajes Estados de Cuentas TC')

@if (can_not_do('mensaje_estado_tc'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents') 
  
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">                                            

                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='0|desc'>
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Mensaje_1</th>  
                                <th>Mensaje_2</th>  
                                <th>Usuario</th>                                                               
                                <th>Fecha</th>                                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mensajeshst as $msg)
                                <tr>
                                    <td>{{ $msg->cdmsg_intm }}</td>
                                    <td>{{ trim($msg->d3msg_intm) }}</td>  
                                    <td>{{ trim($msg->d4msg_intm) }}</td>                                      
                                    <td>{{ trim($msg->usuar_intm) }}</td>  
                                    <td>{{ trim($msg->fecha_intm) }}</td>                                                                                              
                                </tr>
                            @endforeach
                             <a class="btn btn-info btn-xs"href="{{route('mantenimientos.menstc.index')}}"><i class="fa fa-arrow-left"></i> Atrás</a>                        

                        </tbody>
                    </table>   
                    {{ $mensajeshst->appends(Request::all())->links() }} 
                               
                </div>
            </div>
        </div>
    </div>    
@endsection
