@extends('layouts.master')

@section('title', 'Clientes - NCF')

@section('page_title', 'Nuevo NCF (Divisas)')

@if (can_not_do('customer_ncf'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')
    @if (!session()->has('customer_divisa'))
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Filtros de Búsqueda</h3>
                    </div>
                    <div class="panel-body">
                        <form method="get" action="{{ route('customer.ncf.divisa.new.index') }}" id="form">
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group{{ $errors->first('day_from') ? ' has-error':'' }}">
                                        <label class="control-label">Día (Desde)</label>
                                        <input type="number" class="form-control input-sm" name="day_from" value="{{ old('day_from') }}" max="31" min="1">
                                        <span class="help-block">{{ $errors->first('day_from') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group{{ $errors->first('day_to') ? ' has-error':'' }}">
                                        <label class="control-label">Día (Hasta)</label>
                                        <input type="number" class="form-control input-sm" name="day_to" value="{{ old('day_to') }}" max="31" min="1">
                                        <span class="help-block">{{ $errors->first('day_to') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group{{ $errors->first('month') ? ' has-error':'' }}">
                                        <label class="control-label">Mes</label>
                                        <select class="form-control input-sm" name="month">
                                            @foreach (get_months() as $key => $month)
                                                <option value="{{ $key }}" {{ old('month') == $key ? 'selected':'' }}>{{ $month }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">{{ $errors->first('month') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group{{ $errors->first('year') ? ' has-error':'' }}">
                                        <label class="control-label">Año</label>
                                        <input type="number" class="form-control input-sm" name="year" value="{{ old('year') ? old('year'):(new DateTime)->format('Y') }}" max="{{ (new DateTime)->format('Y') }}" min="2015">
                                        <span class="help-block">{{ $errors->first('year') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group{{ $errors->first('customer_code') ? ' has-error':'' }}">
                                        <label class="control-label"># Cliente</label>
                                        <input type="text" class="form-control input-sm" name="customer_code" placeholder="código" value="{{ old('customer_code') }}">
                                        <span class="help-block">{{ $errors->first('customer_code') }}</span>
                                    </div>
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <a class="btn btn-info btn-xs" href="{{ route('customer.ncf.index') }}"><i class="fa fa-arrow-left"></i> Atras</a>
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando transacciones...">Buscar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('customer_divisa'))
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Transacciones Encontradas de {{ session()->get('customer_divisa')->getName() }}
                            <a
                                class="btn btn-danger pull-right btn-xs"
                                href="javascript:void(0)"
                                onclick="action('eliminar_all', this)"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Cancelar Todo"
                                style="margin-top: -3px;color: #FFFFFF;">
                                <i class="fa fa-close"></i>
                            </a>
                            <form
                                style="display: none;"
                                action="{{ route('customer.ncf.divisa.new.destroy', ['id' => 'all']) }}"
                                method="post" id="form_eliminar_all">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label class="control-label">Nombre y Apellido</label>
                                    <p class="form-control-static">{{ session()->get('customer_divisa')->getName() }}</p>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label class="control-label">Identificación ({{ session()->get('customer_divisa')->getDocument() ? 'Cédula' : 'Pasaporte' }})</label>
                                    @if (session()->get('customer_divisa')->getDocument())
                                        <p class="form-control-static">{{ session()->get('customer_divisa')->getDocument() }}</p>
                                    @else
                                        <p class="form-control-static">{{ session()->get('customer_divisa')->getPassport() }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label class="control-label">Monto Total</label>
                                    <p class="form-control-static">RD$ {{ number_format(session()->get('customer_divisa')->totalAmount, 2) }}</p>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <a
                                    class="btn btn-success btn-xs pull-right"
                                    onclick="action('save', this)"
                                    href="javascript:void(0)">
                                    Guardar NCF (Divisas)
                                </a>
                                <form
                                    style="display: none;"
                                    action="{{ route('customer.ncf.divisa.new.store') }}"
                                    method="post" id="form_save">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>

                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='2|asc'>
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
                                @foreach (session()->get('transactions_divisa') as $index => $transaction)
                                    <tr>
                                        <td>{{ $transaction->description }}</td>
                                        <td align="center">{{ $transaction->getCurrency() }}</td>
                                        <td align="right">{{ number_format($transaction->getAmount(), 2) }}</td>
                                        <td align="center">{{ $transaction->getDate() }}</td>
                                        <td align="center" width="20">
                                            <a href="{{ route('customer.ncf.divisa.new.detail.edit', ['id' => $index]) }}" class="naranja" data-toggle="tooltip" data-placement="top" title="Editar Detalle"><i class="fa fa-edit fa-fw"></i></a>
                                            <a
                                                href="javascript:void(0)"
                                                onclick="action({{ $index }}, this)"
                                                class="rojo"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Eliminar Detalle">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                            <form
                                                style="display: none;"
                                                action="{{ route('customer.ncf.divisa.new.detail.destroy', ['id' => $index]) }}"
                                                method="post" id="form_{{ $index }}">
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
        </div>
    @endif

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        function action(id, el)
        {
            switch (id) {
                case 'eliminar_all':
                    res = confirm('Realmente desea cancelar todo el ncf?');
                    break;
                case 'save':
                    res = confirm('Realmente desea guardar este ncf?');
                    break;
                default:
                    res = confirm('Realmente desea eliminar este detalle?');
            }

            if (!res) {
                event.preventDefault();
                return;
            }

            $(el).remove();

            $('#form_' + id).submit();
        }
    </script>

@endsection
