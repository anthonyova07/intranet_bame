@extends('layouts.master')

@section('title', 'Mensajes Estados de TC')

@section('page_title', 'Mensajes Estados de Cuentas TC')

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
                                <th>Linea 1</th>                                                                
                                <th>Linea 2</th>   
                                <th>Fecha</th>                                                                
                                <th>Usuario</th> 
                                <th>Opciones</th>                                                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mensajes as $msg)
                                <tr>
                                    <td>{{ $msg->cdmsg_intm }} </td>
                                    <td>{{ trim($msg->d3msg_intm) }}</td>                                      
                                    <td>{{ trim($msg->d4msg_intm) }}</td>  
                                    <td>{{ trim($msg->fecha_intm) }}</td>  
                                    <td>{{ trim($msg->usuar_intm) }}</td>  

                                    <td align="center" width="20">
                                      <a href="{{URL::action('Mantenimientos\MensTC\Mensajecontroller@edit',$msg->cdmsg_intm )}}" class="naranja" data-toggle="tooltip" data-placement="top" title="Editar Mensaje"><i class="fa fa-edit fa-fw"></i></a>   

                                       <a href="{{URL::action('Mantenimientos\MensTChst\MensajeHstcontroller@reportehistoricomsg', $msg->cdmsg_intm)}}"  data-toggle="tooltip" data-placement="top" title="Historico Mensaje"><i class="fa fa-share fa-fw"></i></a>                             
                                    </td>                                              
                                  
                                </tr>
                            @endforeach
                        </tbody>
                    </table>   
                     {{ $mensajes->appends(Request::all())->links() }} 
                               
                </div>
            </div>
        </div>
    </div>    
@endsection
