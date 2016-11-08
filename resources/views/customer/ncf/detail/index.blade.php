@extends('layouts.master')

@section('title', 'Clientes - NCF')

@section('page_title', 'Detalle del la Factura: ' . $ncf->getInvoice())

@if (can_not_do('customer_ncf'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <a class="btn btn-info btn-xs" href="{{ route('customer.ncf.index', Request::all()) }}"><i class="fa fa-arrow-left"></i> Atras</a>
                <a style="font-size: 13px;" class="label btn-warning pull-right" target="__blank" href="{{ route('customer.ncf.show', ['invoice' => $ncf->getInvoice()]) }}">Imprimir</a>

                <br><br>

                <div class="col-xs-12 well well-sm">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td align="right">
                                    <b># Factura: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->getInvoice() }}
                                </td>
                                <td align="right">
                                    <b># Producto: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->getProduct() }}
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    <b># Cliente: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->getCustomerNumber() }}
                                </td>
                                <td align="right">
                                    <b>Nombre: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->getName() }}
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    <b>NCF: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->getNcf() }}
                                </td>
                                <td align="right">
                                    <b>Fecha Generado: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->getDateGenerated() }}
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    <b>Monto: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->getAmount() }}
                                </td>
                                <td align="right">
                                    <b>Fecha Proceso: </b>
                                </td>
                                <td align="left">
                                    {{ $ncf->getDateProcess() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <table class="table table-striped table-bordered table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>Secuencia</th>
                            <th>Cantidad</th>
                            <th>Descripción</th>
                            <th>Moneda</th>
                            <th>Monto</th>
                            <th>Impuesto</th>
                            <th>Fecha Generado</th>
                            <th>Estatus</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details as $detail)
                            <tr>
                                <td>{{ $detail->getSequence() }}</td>
                                <td>{{ $detail->getQuantity() }}</td>
                                <td>{{ $detail->getDescription() }}</td>
                                <td align="center">{{ 'RD$' }}</td>
                                <td align="right">{{ number_format($detail->getAmount(), 2) }}</td>
                                <td align="right">{{ $detail->getTaxAmount() }}</td>
                                <td>{{ $detail->getDateGenerated() }}</td>
                                <td align="center"><span class="label label-{{ $detail->getStatus() == 'A' ? 'success':'danger' }}">{{ $detail->getStatus() == 'A' ? 'Activo':'Anulado' }}</span></td>
                                <td align="center">
                                    <a href="{{ route('customer.ncf.{invoice}.detail.edit', ['invoice' => $ncf->getInvoice(), 'id' => $detail->getSequence()]) }}" class="naranja" data-toggle="tooltip" data-placement="top" title="Editar Descripción"><i class="fa fa-edit fa-fw"></i></a>
                                    @if ($detail->getStatus() == 'R')
                                        <a
                                            id="link_a_r"
                                            onclick="cancel({{ $detail->getSequence() }}, this)"
                                            href="javascript:void(0)"
                                            class="link_activar verde"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Activar Este Detalle">
                                            <i class="fa fa-check fa-fw"></i>
                                        </a>
                                    @else
                                        <a
                                            id="link_a_r"
                                            onclick="cancel({{ $detail->getSequence() }}, this)"
                                            href="javascript:void(0)"
                                            class="link_anular rojo"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Anular Este Detalle">
                                            <i class="fa fa-times fa-fw"></i>
                                        </a>
                                    @endif
                                    <form
                                        style="display: none;"
                                        action="{{ route('customer.ncf.{invoice}.detail.destroy', ['invoice' => $ncf->getInvoice(), 'id' => $detail->getSequence()]) }}"
                                        method="post" id="form_eliminar_{{ $detail->getSequence() }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function cancel(id, el)
        {
            res = confirm('Realmente desea cambiar este detalle de la factura: ' + {{ $ncf->getInvoice() }} + '?');

            if (!res) {
                event.preventDefault();
                return;
            }

            $(el).remove();

            $('#form_eliminar_' + id).submit();
        }
    </script>

@endsection
