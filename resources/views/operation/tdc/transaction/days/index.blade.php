@extends('layouts.master')

@section('title', 'Transacciones ITC')

@section('page_title', 'Transacciones ITC')

@if (can_not_do('op_tdc_trx_days'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">

        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Búscar Transacciones</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="{{ route('operation.tdc.transactions.days.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('date_from') ? ' has-error':'' }}">
                                    <label class="control-label">Desde</label>
                                    <input type="date" class="form-control input-sm" name="date_from" value="{{ old('date_from') }}">
                                    <span class="help-block">{{ $errors->first('date_from') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('date_to') ? ' has-error':'' }}">
                                    <label class="control-label">Hasta</label>
                                    <input type="date" class="form-control input-sm" name="date_to" value="{{ old('date_to') }}">
                                    <span class="help-block">{{ $errors->first('date_to') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('transaction_type') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo de Transacción</label>
                                    <select class="form-control input-sm" name="transaction_type">
                                        <option value="">Seleccione un tipo de transacción</option>
                                        @foreach ($descriptions->where('prefi_desc', 'SAT_CODTR ')->sortBy('nombr_desc')->values() as $transaction_type)
                                            <option value="{{ intval(clear_str($transaction_type->getCode())) }}" {{ Request::get('transaction_type') == clear_str($transaction_type->getCode()) ? 'selected':'' }}>{{ $transaction_type->getDescription() }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('transaction_type') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('concept') ? ' has-error':'' }}">
                                    <label class="control-label">Concepto</label>
                                    <select class="form-control input-sm" name="concept">
                                        <option value="">Seleccione un tipo de transacción</option>
                                        @foreach ($descriptions->where('prefi_desc', 'SAT_CONCEP')->sortBy('nombr_desc')->values() as $concept)
                                            <option
                                                value="{{ intval(clear_str($concept->getCode())) }}"
                                                {{ Request::get('concept') != null ? (Request::get('concept') == intval(clear_str($concept->getCode())) ? 'selected':'') : '' }}>
                                                {{ $concept->getDescription() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('concept') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('currency') ? ' has-error':'' }}">
                                    <label class="control-label">Moneda</label>
                                    <select class="form-control input-sm" name="currency">
                                        <option value="" {{ Request::get('currency') ? 'selected':'' }}>Todas</option>
                                        <option value="214" {{ Request::get('currency') == '214' ? 'selected':'' }}>DOP</option>
                                        <option value="840" {{ Request::get('currency') == '840' ? 'selected':'' }}>USD</option>
                                    </select>
                                    <span class="help-block">{{ $errors->first('currency') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando vacantos...">Buscar</button>
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

                    <a style="font-size: 13px;" class="label btn-success pull-right" href="{{ route('operation.tdc.transactions.days.index', array_merge(Request::except(['page']), ['format' => 'excel']) ) }}">Exportar Excel</a>

                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th># Tarjeta</th>
                                <th>Idenficación</th>
                                <th>Nombre Plástico</th>
                                <th>Descripción</th>
                                <th>Moneda</th>
                                <th>Monto</th>
                                <th>Tipo TRX</th>
                                <th>Concepto</th>
                                <th>Fecha de Proceso</th>
                                <th>Fecha de TRX</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->getCreditCard() }}</td>
                                    @if ($transaction->creditcard)
                                        <td>{{ $transaction->creditcard->getIdentification() }}</td>
                                        <td>{{ $transaction->creditcard->getPlasticName() }}</td>
                                    @else
                                        <td></td>
                                        <td></td>
                                    @endif
                                    <td>{{ $transaction->getDescription() }}</td>
                                    <td>{{ $transaction->getCurrency() == '214' ? 'DOP' : 'USD' }}</td>
                                    <td align="right">{{ number_format($transaction->getAmount(), 2) }}</td>
                                    <td>{{ $transaction->transaction_type->getDescription() }}</td>
                                    <td>{{ $transaction->transaction_concep->getDescription() }}</td>
                                    <td>{{ $transaction->getProcessDate() }}</td>
                                    <td>{{ $transaction->getTransactionDate() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $transactions->appends(Request::all())->links() }}
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $('#form').submit(function (vacant) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
