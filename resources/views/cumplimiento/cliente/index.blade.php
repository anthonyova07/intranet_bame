@extends('layouts.master')

@section('title', 'Mantenimiento de Cliente')

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
                    <h3 class="panel-title">Filtro de Búsqueda</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="{{ route('cumplimiento.cliente.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('codigo') ? ' has-error':'' }}">
                                    <label class="control-label">Codigo Cliente</label>
                                    <input type="number" class="form-control input-sm" name="codigo" placeholder="0" value="{{ old('codigo') }}>
                                    <span class="help-block">{{ $errors->first('codigo') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Mantenimiento de Clientes..." style="margin-top: 22px;">Buscar</button>                            
                            </div>                             
                        </div>                        
                    </form>
                </div>                    
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">                                           
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='0|desc'>
                        <thead>
                            <tr>
                                <th>Cod.Cliente</th>
                                <th>Nombre</th>                                
                                <th>Cedula</th>
                                <th>PasaPorte</th>  
                                <th>Editar</th>                      	          
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $cli)
                                <tr>
                                    <td>{{ $cli->cuscun }}</td>
                                    <td>{{ $cli->cusna1 }}</td>                                    
                                    <td>{{ $cli->cusln3 }}</td>                                    
                                    <td>{{ $cli->cusidn }}</td>                                    
                                    <td>                                       

                                    <a href="{{URL::action('Cumplimiento\Cliente\CumstController@edit',$cli->cuscun)}}" title="Editar Cliente"> <i class="fa fa-share fa-fw"></i></a>                             

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>   
                     {{ $clientes->appends(Request::all())->links() }}                                    
                    

                </div>
            </div>
        </div>
    </div>    
@endsection
