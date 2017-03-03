@extends('layouts.master')

@section('title', 'Historico Cliente')

@section('page_title', 'Consulta Historico de Cliente')

@if (can_not_do('historico_producto'))
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
                    <form method="get" action="{{ route('consultas.historicoproducto.index') }}" id="form">
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
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Consultando Historico..." style="margin-top: 22px;">Consultar Historico</button>
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
                                <th>Producto</th>                                
                                <th>Tipo</th>
                                <th>Balance</th>
                                <th>Estatus</th>
                                <th>Dia</th>
                                <th>Mes</th>
                                <th>Año</th>
                                <th>Corte</th>                              
                                <th>Moneda</th>
                                <th>DiaC</th>
                                <th>MesC</th>
                                <th>AñoC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $prod)
                                <tr>
                                    <td>{{ $prod->hiscun }}</td>
                                    <td>{{ $prod->hisacc }}</td>                                    
                                    <td>{{ $prod->TipoProducto() }}</td>
                                    <td align="right">{{ $prod->Balance() }}</td>
                                    <td>{{ $prod->hissts }}</td>
                                    <td>{{ $prod->hisodd }}</td>
                                    <td>{{ $prod->hisodm }}</td>
                                    <td>{{ $prod->hisody }}</td>
                                    <td>{{ $prod->hiscor }}</td>
                                    <td>{{ $prod->hisccy }}</td>
                                    <td>{{ $prod->hislpd }}</td>
                                    <td>{{ $prod->hislpm }}</td>
                                    <td>{{ $prod->hislpy }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                  
                      
                </div>
            </div>
        </div>
    </div>    
@endsection
