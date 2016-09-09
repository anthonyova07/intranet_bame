@extends('layouts.master')

@section('title', 'Clientes - NCF')

@section('page_title', 'Nuevo NCF (No IBS)')

@if (can_not_do('clientes_ncf'))
    @section('contents')
        @include('partials.access_denied')
    @endsection
@endif

@section('contents')
{{-- {{ dd(session()->get('cliente_noibs')) }} --}}
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Información del Cliente
                    </h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="{{ route('clientes::ncfs::no_ibs::nuevo') }}" id="form_consulta">
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('nombres_apellidos') ? ' has-error':'' }}">
                                    <label class="control-label">Nombres y Apellidos</label>
                                    <input type="text" class="form-control" name="nombres_apellidos" value="{{ old('nombres_apellidos') }}">
                                    <span class="help-block">{{ $errors->first('nombres_apellidos') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('tipo_identificacion') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo de Identificación</label>
                                    <select class="form-control" name="tipo_identificacion">
                                        @foreach (get_identification_types() as $key => $tipo_identificacion)
                                            <option value="{{ $key }}" {{ old('tipo_identificacion') == $key ? 'selected':'' }}>{{ $tipo_identificacion }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('tipo_identificacion') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('identificacion') ? ' has-error':'' }}">
                                    <label class="control-label">Identificación</label>
                                    <input type="text" class="form-control" name="identificacion" value="{{ old('identificacion') }}">
                                    <span class="help-block">{{ $errors->first('identificacion') }}</span>
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
                        </div>
                        {{ csrf_field() }}
                        <a href="{{ route('clientes::ncfs::consulta') }}" class="btn btn-default btn-sm">Cancelar</a>
                        <button type="submit" class="btn btn-danger btn-sm" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('cliente_noibs'))
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Transacciones para el NCF de {{ session()->get('cliente_noibs')->NOMBRES_APELLIDOS }}
                            <a class="btn btn-warning pull-right btn-xs" href="{{ route('clientes::ncfs::no_ibs::eliminar_todo') }}" data-toggle="tooltip" data-placement="top" title="Eliminar Todo" style="margin-top: -3px;color: #FFFFFF;">
                                <i class="fa fa-close"></i>
                            </a>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-2">
                                <a class="btn btn-danger btn-sm" href="{{ route('clientes::ncfs::no_ibs::detalle::nuevo') }}">Agregar Transacción</a>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label class="control-label">Nombre y Apellido</label>
                                    <p class="form-control-static">{{ session()->get('cliente_noibs')->NOMBRES_APELLIDOS }}</p>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label class="control-label">Identificación ({{ get_identification_types(session()->get('cliente_noibs')->TIPO_IDENTIFICACION) }})</label>
                                    <p class="form-control-static">{{ session()->get('cliente_noibs')->IDENTIFICACION }}</p>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label class="control-label">Monto Total</label>
                                    <p class="form-control-static">RD$ {{ number_format(collect(session()->get('transacciones_noibs'))->sum('MONTO') + collect(session()->get('transacciones_noibs'))->sum('IMPUESTO'), 2) }}</p>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <a class="btn btn-success btn-sm pull-right" href="{{ route('clientes::ncfs::no_ibs::guardar') }}">Guardar NCF (No IBS)</a>
                            </div>
                        </div>

                        <table class="table table-striped table-bordered table-hover table-condensed datatable">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Moneda</th>
                                    <th>Monto</th>
                                    <th>Impuesto (18%)</th>
                                    <th>Fecha</th>
                                    <th style="width: 26px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (session()->has('transacciones_noibs'))
                                    @foreach (session()->get('transacciones_noibs') as $index => $transaccion)
                                        <tr>
                                            <td>{{ $transaccion->DESCRIPCION }}</td>
                                            <td align="center">RD$</td>
                                            <td align="right">{{ number_format($transaccion->MONTO, 2) }}</td>
                                            <td align="right">{{ number_format($transaccion->IMPUESTO, 2) }}</td>
                                            <td align="center">{{ $transaccion->DIA . '/' . $transaccion->MES . '/' . $transaccion->ANIO }}</td>
                                            <td align="center" width="20">
                                                <a href="{{ route('clientes::ncfs::no_ibs::detalle::editar', ['id' => $index]) }}" class="naranja" data-toggle="tooltip" data-placement="top" title="Editar Detalle"><i class="fa fa-edit fa-fw"></i></a>
                                                <a href="{{ route('clientes::ncfs::no_ibs::detalle::eliminar', ['id' => $index]) }}" class="rojo" data-toggle="tooltip" data-placement="top" title="Eliminar Detalle"><i class="fa fa-trash fa-fw"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
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
