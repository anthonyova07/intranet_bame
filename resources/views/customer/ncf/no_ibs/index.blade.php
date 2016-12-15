@extends('layouts.master')

@section('title', 'Clientes - NCF')

@section('page_title', 'Nuevo NCF (No IBS)')

@if (can_not_do('customer_ncf'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')
    @if (!session()->has('customer_no_ibs'))
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Información del Cliente
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="get" action="{{ route('customer.ncf.no_ibs.new.index') }}" id="form">
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="form-group{{ $errors->first('to_name') ? ' has-error':'' }}">
                                        <label class="control-label">A nombre de</label>
                                        <input type="text" class="form-control input-sm" name="to_name" value="{{ old('to_name') }}">
                                        <span class="help-block">{{ $errors->first('to_name') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group{{ $errors->first('identification_type') ? ' has-error':'' }}">
                                        <label class="control-label" title="Tipo de Identificación" data-toggle="tooltip">TP</label>
                                        <select class="form-control input-sm" name="identification_type">
                                            @foreach (get_identification_types() as $key => $identification_type)
                                                <option value="{{ $key }}" {{ old('identification_type') == $key ? 'selected':'' }}>{{ $identification_type }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">{{ $errors->first('identification_type') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group{{ $errors->first('identification') ? ' has-error':'' }}">
                                        <label class="control-label">Identificación</label>
                                        <input type="text" class="form-control input-sm" name="identification" value="{{ old('identification') }}">
                                        <span class="help-block">{{ $errors->first('identification') }}</span>
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
                            </div>
                            {{ csrf_field() }}
                            <a class="btn btn-info btn-xs" href="{{ route('customer.ncf.index') }}"><i class="fa fa-arrow-left"></i> Atras</a>
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('customer_no_ibs'))
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Transacciones para el NCF de {{ session()->get('customer_no_ibs')->to_name }}
                            <a
                                class="label btn-warning pull-right btn-xs"
                                href="javascript:void(0)"
                                onclick="action('eliminar_all', this)"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Cancelar Todo"
                                style="color: #FFFFFF;">
                                <i class="fa fa-close"></i>
                            </a>
                            <form
                                style="display: none;"
                                action="{{ route('customer.ncf.no_ibs.new.destroy', ['id' => 'all']) }}"
                                method="post" id="form_eliminar_all">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-2">
                                <a class="btn btn-danger btn-xs" href="{{ route('customer.ncf.no_ibs.new.detail.create') }}">Agregar Detalle</a>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label class="control-label">Nombre y Apellido</label>
                                    <p class="form-control-static">{{ session()->get('customer_no_ibs')->to_name }}</p>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label class="control-label">Identificación ({{ get_identification_types(session()->get('customer_no_ibs')->identification_type) }})</label>
                                    <p class="form-control-static">{{ session()->get('customer_no_ibs')->identification }}</p>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label class="control-label">Monto Total</label>
                                    <p class="form-control-static">RD$ {{ number_format(collect(session()->get('transactions_no_ibs'))->sum('amount') + collect(session()->get('transactions_no_ibs'))->sum('tax_amount'), 2) }}</p>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <a
                                    class="label btn-success pull-right"
                                    onclick="action('save', this)"
                                    style="font-size: 13px;"
                                    href="javascript:void(0)">
                                    Guardar NCF (No IBS)
                                </a>
                                <form
                                    style="display: none;"
                                    action="{{ route('customer.ncf.no_ibs.new.store') }}"
                                    method="post" id="form_save">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>

                        <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|asc'>
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Moneda</th>
                                    <th>Monto</th>
                                    <th>Impuesto (18%)</th>
                                    <th>Fecha</th>
                                    <th style="width: 48px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (session()->has('transactions_no_ibs'))
                                    @foreach (session()->get('transactions_no_ibs') as $index => $transaction)
                                        <tr>
                                            <td>{{ $transaction->description }}</td>
                                            <td align="center">RD$</td>
                                            <td align="right">{{ number_format($transaction->amount, 2) }}</td>
                                            <td align="right">{{ number_format($transaction->tax_amount, 2) }}</td>
                                            <td align="center">{{ $transaction->day . '/' . $transaction->month . '/' . $transaction->year }}</td>
                                            <td align="center" width="20">
                                                <a href="{{ route('customer.ncf.no_ibs.new.detail.edit', ['id' => $index]) }}" class="naranja" data-toggle="tooltip" data-placement="top" title="Editar Detalle"><i class="fa fa-edit fa-fw"></i></a>
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
                                                    action="{{ route('customer.ncf.no_ibs.new.detail.destroy', ['id' => $index]) }}"
                                                    method="post" id="form_{{ $index }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                </form>
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
