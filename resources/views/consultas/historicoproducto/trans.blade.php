@extends('layouts.master')

@section('title', 'Listado de Movimientos')

@section('page_title', 'Listado de Movimientos')

@if (can_not_do('historico_producto'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')  

    <div class="row">
        <div class="col-xs-12">               

            <div class="panel panel-default">
                <div class="panel-body">                                                           

                    <a class="btn btn-info btn-xs"href="{{route('consultas.historicoproducto.index',array_merge(Request::all(),['page' => 1]))}}"><i class="fa fa-arrow-left"></i> Atras</a>     

                    <a style="font-size: 13px;" class="label btn-warning pull-right" target="__blank" href="">Excel</a>
                    

                    <a style="font-size: 13px;" class="label btn-warning pull-right" target="__blank" href="{{URL::action('Consultas\HistoricoProducto\TransaccionController@reportetranspdf',$cuenta)}}">PDF</a>

                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='0|desc'>
                        <thead>
                            <tr>
                                <th>Cod.Cliente</th>
                                <th>Producto</th>                                
                                <th>Dia</th>
                                <th>Mes</th>
                                <th>Año</th>                                                                
                                <th>Descripcion</th>
                                <th>Usuario</th>
                                <th>Moneda</th>
                                <th>Monto</th>
                                <th>Corte</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transacciones as $tran)
                                <tr>
                                    <td>{{ $tran->tracun }}</td>
                                    <td>{{ $tran->traacc }}</td>                                    
                                    <td>{{ $tran->travdd }}</td>
                                    <td>{{ $tran->travdm }}</td>
                                    <td>{{ $tran->travdy }}</td>                                    
                                    <td>{{ $tran->tranar }}</td>
                                    <td>{{ $tran->trausr }}</td>
                                    <td>{{ $tran->traccy }}</td>
                                    <td>{{ $tran->traamt }}</td>
                                    <td>{{ $tran->tracor }}</td>                                    
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>  
                    {{ $transacciones->appends(Request::all())->links() }}  
                </div>
            </div>
        </div>
    </div>    
@endsection
