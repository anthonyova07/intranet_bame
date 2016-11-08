@extends('layouts.master')

@section('title', 'Clientes - NCF')

@section('page_title', 'Consulta de NCFs')

@if (can_not_do('customer_ncf'))
    @section('contents')
        @include('layouts.partials.access_denied')
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
                    <form method="get" action="{{ route('customer.ncf.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('customer_number') ? ' has-error':'' }}">
                                    <label class="control-label"># Cliente</label>
                                    <input type="text" class="form-control input-sm" name="customer_number" placeholder="código" value="{{ old('customer_number') }}">
                                    <span class="help-block">{{ $errors->first('customer_number') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('product') ? ' has-error':'' }}">
                                    <label class="control-label"># Producto</label>
                                    <input type="text" class="form-control input-sm" name="product" placeholder="0000000000" value="{{ old('product') }}">
                                    <span class="help-block">{{ $errors->first('product') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-1">
                                <div class="form-group{{ $errors->first('month_process') ? ' has-error':'' }}">
                                    <label class="control-label" title="Mes del Proceso" data-toggle="tooltip">Mes</label>
                                    <input type="text" class="form-control input-sm" name="month_process" placeholder="00" value="{{ old('month_process') }}">
                                    <span class="help-block">{{ $errors->first('month_process') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-1">
                                <div class="form-group{{ $errors->first('year_process') ? ' has-error':'' }}">
                                    <label class="control-label" title="Año del Proceso" data-toggle="tooltip">Año</label>
                                    <input type="text" class="form-control input-sm" name="year_process" placeholder="0000" value="{{ old('year_process') }}">
                                    <span class="help-block">{{ $errors->first('year_process') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('ncf') ? ' has-error':'' }}">
                                    <label class="control-label"># NCF</label>
                                    <input type="text" class="form-control input-sm" name="ncf" placeholder="0000" value="{{ old('ncf') }}">
                                    <span class="help-block">{{ $errors->first('ncf') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('invoice') ? ' has-error':'' }}">
                                    <label class="control-label"># Factura</label>
                                    <input type="text" class="form-control input-sm" name="invoice" placeholder="0000" value="{{ old('invoice') }}">
                                    <span class="help-block">{{ $errors->first('invoice') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Consultando ncfs..." style="margin-top: 27px;">Consultar NCFs</button>
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
                    <a class="btn btn-danger btn-xs" href="{{ route('customer.ncf.divisa.new.index') }}">Nuevo NCF (Divisas)</a>
                    <a class="btn btn-warning btn-xs pull-right" href="{{ route('customer.ncf.no_ibs.new.index') }}">Nuevo NCF (No IBS)</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='0|desc'>
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
                                <th style="width: 48px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ncfs as $ncf)
                                <tr>
                                    <td>{{ $ncf->getInvoice() }}</td>
                                    <td>{{ $ncf->getCustomerNumber() }}</td>
                                    <td>{{ $ncf->getName() }}</td>
                                    <td>{{ $ncf->getProduct() }}</td>
                                    <td>{{ $ncf->getNcf() }}</td>
                                    <td>{{ $ncf->getDateProcess() }}</td>
                                    <td>{{ $ncf->getDateGenerated() }}</td>
                                    <td align="right">{{ $ncf->getAmount() }}</td>
                                    <td align="center" width="20">
                                        <a
                                            href="{{ route('customer.ncf.{invoice}.detail.index', array_merge(Request::all(), ['invoice' => $ncf->getInvoice()])) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Ver Detalle de la factura {{ $ncf->getInvoice() }}">
                                            <i class="fa fa-share fa-fw"></i>
                                        </a>
                                        <a
                                            onclick="cancel({{ $ncf->getInvoice() }}, this)"
                                            href="javascript:void(0)"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Anular Factura {{ $ncf->getInvoice() }}"
                                            class="rojo link_anular">
                                            <i class="fa fa-close fa-fw"></i>
                                        </a>
                                        <form
                                            style="display: none;"
                                            action="{{ route('customer.ncf.destroy', ['id' => $ncf->getInvoice()]) }}"
                                            method="post" id="form_eliminar_{{ $ncf->getInvoice() }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $ncfs->appends(Request::all())->links() }}

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        function cancel(id, el)
        {
            res = confirm('Realmente desea anular esta factura?');

            if (!res) {
                event.preventDefault();
                return;
            }

            $(el).remove();

            $('#form_eliminar_' + id).submit();
        }
    </script>

@endsection
