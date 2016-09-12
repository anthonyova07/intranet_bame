@extends('layouts.master')

@section('title', 'Clientes - NCF')

@section('page_title', 'Consulta de NCFs')

@if (can_not_do('clientes_ncf'))
    @section('contents')
        @include('partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Filtros de Búsqueda</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="" id="form_consulta">
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('codigo_cliente') ? ' has-error':'' }}">
                                    <label class="control-label"># Cliente</label>
                                    <input type="text" class="form-control" name="codigo_cliente" placeholder="código" value="{{ old('codigo_cliente') }}">
                                    <span class="help-block">{{ $errors->first('codigo_cliente') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('producto') ? ' has-error':'' }}">
                                    <label class="control-label"># Producto</label>
                                    <input type="text" class="form-control" name="producto" placeholder="0000000000" value="{{ old('producto') }}">
                                    <span class="help-block">{{ $errors->first('producto') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('mes_proceso') ? ' has-error':'' }}">
                                    <label class="control-label">Mes del Proceso</label>
                                    <input type="text" class="form-control" name="mes_proceso" placeholder="00" value="{{ old('mes_proceso') }}">
                                    <span class="help-block">{{ $errors->first('mes_proceso') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('anio_proceso') ? ' has-error':'' }}">
                                    <label class="control-label">Año del Proceso</label>
                                    <input type="text" class="form-control" name="anio_proceso" placeholder="0000" value="{{ old('anio_proceso') }}">
                                    <span class="help-block">{{ $errors->first('anio_proceso') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('ncf') ? ' has-error':'' }}">
                                    <label class="control-label"># NCF</label>
                                    <input type="text" class="form-control" name="ncf" placeholder="0000" value="{{ old('ncf') }}">
                                    <span class="help-block">{{ $errors->first('ncf') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" id="btn_submit" data-loading-text="Consultando ncfs..." style="margin-top: 27px;">Consultar NCFs</button>
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
                    <a class="btn btn-danger btn-sm" href="{{ route('clientes::ncfs::divisas::nuevo') }}">Nuevo NCF (Divisas)</a>
                    <a class="btn btn-warning btn-sm pull-right" href="{{ route('clientes::ncfs::no_ibs::nuevo') }}">Nuevo NCF (No IBS)</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable">
                        <thead>
                            <tr>
                                <th>Factura</th>
                                <th>Cliente</th>
                                <th>Nombre</th>
                                <th>Producto</th>
                                <th>NCF</th>
                                <th>Fec.Proceso</th>
                                <th>Fec.Generado</th>
                                <th>Monto</th>
                                <th style="width: 26px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (session()->has('ncfs'))
                                @foreach (session()->get('ncfs') as $ncf)
                                    <tr>
                                        <td>{{ $ncf->FACTURA }}</td>
                                        <td>{{ $ncf->CODIGO_CLIENTE }}</td>
                                        <td>{{ $ncf->CODIGO_CLIENTE ? $ncf->NOMBRE:$ncf->NOMBRE_ALT }}</td>
                                        <td>{{ $ncf->PRODUCTO }}</td>
                                        <td>{{ $ncf->NCF }}</td>
                                        <td>{{ $ncf->MES_PROCESO . '/' . $ncf->ANIO_PROCESO }}</td>
                                        <td>{{ $ncf->DIA_GENERADO . '/' . $ncf->MES_GENERADO . '/' . $ncf->ANIO_GENERADO }}</td>
                                        <td align="right">{{ $ncf->MONTO }}</td>
                                        <td align="center" width="20">
                                            <a href="{{ route('clientes::ncfs::detalles::consulta', ['ncf' => $ncf->FACTURA, 'es_cliente' => ($ncf->CODIGO_CLIENTE ? 1:0)]) }}" data-toggle="tooltip" data-placement="top" ncf="{{ $ncf->NCF }}" title="Ver Detalle del NCF {{ $ncf->NCF }}"><i class="fa fa-align-justify fa-fw"></i></a>
                                            <a href="{{ route('clientes::ncfs::anular', ['ncf' => $ncf->NCF]) }}" class="link_anular rojo" data-toggle="tooltip" data-placement="top" ncf="{{ $ncf->NCF }}" title="Anular NCF {{ $ncf->NCF }}"><i class="fa fa-times fa-fw"></i></a>
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

    <script type="text/javascript">
        $('#form_consulta').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        $('.link_anular').click(function (event) {
            res = confirm('Realmente desea anular el ncf: ' + $(this).attr("ncf") + '?');

            if (!res) {
                event.preventDefault();
            }
        });
    </script>

@endsection
