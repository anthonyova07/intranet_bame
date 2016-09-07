@extends('layouts.master')

@section('title', 'Clientes - NCF')

@section('page_title', 'Detalle del la Factura: ' . $ncf->FACTURA)

@if (can_not_do('clientes_ncf'))
    @section('contents')
        @include('partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <a class="btn btn-danger" href="">Nuevo</a>
                <a class="btn btn-warning pull-right" target="__blank" href="{{ route('clientes::ncf::detalle::imprimir', ['factura' => $ncf->FACTURA]) }}">Imprimir</a>

                <br><br>

                <div class="col-xs-12 well well-sm">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td align="right">
                                    <b># Factura: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->FACTURA }}
                                </td>
                                <td align="right">
                                    <b># Producto: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->PRODUCTO }}
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    <b># Cliente: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->CODIGO_CLIENTE }}
                                </td>
                                <td align="right">
                                    <b>Nombre: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->NOMBRE }}
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    <b>NCF: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->NCF }}
                                </td>
                                <td align="right">
                                    <b>Fecha Generado: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->DIA_GENERADO . '/' . $ncf->MES_GENERADO . '/' . $ncf->ANIO_GENERADO }}
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    <b>Monto: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->MONTO }}
                                </td>
                                <td align="right">
                                    <b>Fecha Proceso: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->MES_PROCESO . '/' . $ncf->ANIO_PROCESO }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <table class="table table-striped table-bordered table-hover table-condensed datatable">
                    <thead>
                        <tr>
                            <th>Secuencia</th>
                            <th>Cantidad</th>
                            <th>Descripción</th>
                            <th>Moneda</th>
                            <th>Monto</th>
                            <th>Fecha Generado</th>
                            <th>Estatus</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->SECUENCIA }}</td>
                                <td>{{ $detalle->CANTIDAD }}</td>
                                <td>{{ $detalle->DESCRIPCION }}</td>
                                <td>{{ $detalle->MONEDA }}</td>
                                <td align="right">{{ $detalle->MONTO }}</td>
                                <td>{{ $detalle->MES_GENERADO . '/' . $detalle->ANIO_GENERADO }}</td>
                                <td align="center"><span class="label label-{{ $detalle->ESTATUS == 'A' ? 'success':'danger' }}">{{ $detalle->ESTATUS == 'A' ? 'Activo':'Anulado' }}</span></td>
                                <td align="center">
                                    @if ($detalle->ESTATUS == 'R')
                                        <a href="{{ route('clientes::ncf::detalle::activar', ['factura' => $detalle->FACTURA, 'secuencia' => $detalle->SECUENCIA]) }}" class="link_activar verde" data-toggle="tooltip" data-placement="top" title="Activar Este Detalle"><i class="fa fa-check fa-fw"></i></a>
                                    @else
                                        <a href="{{ route('clientes::ncf::detalle::anular', ['factura' => $detalle->FACTURA, 'secuencia' => $detalle->SECUENCIA]) }}" class="link_anular rojo" data-toggle="tooltip" data-placement="top" title="Anular Este Detalle"><i class="fa fa-times fa-fw"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
