@extends('layouts.master')

@section('title', 'Clientes - NCF')

@section('page_title', 'Nuevo NCF (Divisas)')

@if (can_not_do('clientes_ncf'))
    @section('contents')
        @include('partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Filtros de Búsqueda</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="{{ route('clientes::ncf::nuevo') }}" id="form_consulta">
                    <div class="row">
                        <div class="col-xs-2">
                            <div class="form-group{{ $errors->first('dia_desde') ? ' has-error':'' }}">
                                <label class="control-label">Día (Desde)</label>
                                <input type="number" class="form-control" name="dia_desde" value="{{ old('dia_desde') }}" max="31" min="1">
                                <span class="help-block">{{ $errors->first('dia_desde') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group{{ $errors->first('dia_hasta') ? ' has-error':'' }}">
                                <label class="control-label">Día (Hasta)</label>
                                <input type="number" class="form-control" name="dia_hasta" value="{{ old('dia_hasta') }}" max="31" min="1">
                                <span class="help-block">{{ $errors->first('dia_hasta') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group{{ $errors->first('mes') ? ' has-error':'' }}">
                                <label class="control-label">Mes</label>
                                <select class="form-control" name="mes">
                                    @foreach (get_months() as $key => $mes)
                                        <option value="{{ $key }}" {{ old('mes') == $key ? 'selected':'' }}>{{ $mes }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block">{{ $errors->first('mes') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group{{ $errors->first('anio') ? ' has-error':'' }}">
                                <label class="control-label">Año</label>
                                <input type="number" class="form-control" name="anio" value="{{ old('anio') ? old('anio'):(new DateTime)->format('Y') }}" max="{{ (new DateTime)->format('Y') }}" min="2015">
                                <span class="help-block">{{ $errors->first('anio') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group{{ $errors->first('codigo_cliente') ? ' has-error':'' }}">
                                <label class="control-label"># Cliente</label>
                                <input type="text" class="form-control" name="codigo_cliente" placeholder="código" value="{{ old('codigo_cliente') }}">
                                <span class="help-block">{{ $errors->first('codigo_cliente') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-2">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger" id="btn_submit" data-loading-text="Buscando transacciones..." style="margin-bottom: 17px;">Buscar Transacciones</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session()->has('cliente'))
        <div class="row">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Transacciones Encontradas
                        <a class="btn btn-warning pull-right btn-xs" href="{{ route('clientes::ncf::eliminar_todo') }}" data-toggle="tooltip" data-placement="top" title="Eliminar Todo" style="margin-top: -3px;">
                            <i class="fa fa-close"></i>
                        </a>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Nombre y Apellido</label>
                                <p class="form-control-static">{{ session()->get('cliente')->NOMBRES . ' ' . session()->get('cliente')->APELLIDOS }}</p>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Identificación ({{ session()->get('cliente')->CEDULA ? 'Cédula' : 'Pasaporte' }})</label>
                                @if (session()->get('cliente')->CEDULA)
                                    <p class="form-control-static">{{ session()->get('cliente')->CEDULA }}</p>
                                @else
                                    <p class="form-control-static">{{ session()->get('cliente')->PASAPORTE }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Monto Total</label>
                                <p class="form-control-static">RD$ {{ number_format(collect(session()->get('transacciones'))->sum('MONTO'), 2) }}</p>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <a class="btn btn-success pull-right" href="{{ route('clientes::ncf::guardar') }}">Guardar NCF (Divisas)</a>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered table-hover table-condensed datatable">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Moneda</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th style="width: 26px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (session()->get('transacciones') as $transaccion)
                                <tr>
                                    <td>{{ $transaccion->DESCRIPCION }}</td>
                                    <td align="center">RD$</td>
                                    <td align="right">{{ number_format($transaccion->MONTO, 2) }}</td>
                                    <td align="center">{{ $transaccion->DIA . '/' . $transaccion->MES . '/' . $transaccion->ANIO }}</td>
                                    <td align="center" width="20">
                                        <a href="{{ route('clientes::ncf::editar', ['id' => $transaccion->ID]) }}" class="naranja" data-toggle="tooltip" data-placement="top" title="Editar Detalle"><i class="fa fa-edit fa-fw"></i></a>
                                        <a href="{{ route('clientes::ncf::eliminar', ['id' => $transaccion->ID]) }}" class="rojo" data-toggle="tooltip" data-placement="top" title="Eliminar Detalle"><i class="fa fa-trash fa-fw"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <script type="text/javascript">
        $('#form_consulta').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
