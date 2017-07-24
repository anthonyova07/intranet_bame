@extends('layouts.master')

@section('title', 'IB')

@section('page_title', 'Consulta de Transacciones IB (ACH)')

@if (can_not_do('ib_transactions'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Filtros de Búsqueda</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="{{ route('ib.transactions.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label class="control-label">Tipo de Transacción</label>
                                    <select class="form-control input-sm" name="transaction_type">
                                        @foreach ($transaction_types as $transaction_type)
                                            <option value="{{ $transaction_type->transactionTypeID }}"{{ request('transaction_type') == $transaction_type->transactionTypeID ? ' selected':'' }}>{{ $transaction_type->longName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('date_from') ? ' has-error':'' }}">
                                    <label class="control-label">Fecha Desde</label>
                                    <input type="datetime-local" class="form-control input-sm" name="date_from" value="{{ old('date_from') }}">
                                    <span class="help-block">{{ $errors->first('date_from') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('date_to') ? ' has-error':'' }}">
                                    <label class="control-label">Fecha Hasta</label>
                                    <input type="datetime-local" class="form-control input-sm" name="date_to" value="{{ old('date_to') }}">
                                    <span class="help-block">{{ $errors->first('date_to') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando eventos...">Buscar</button>
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
                    <a class="pull-right label label-warning" style="font-size: 13px;" target="__blank" href="{{ route('ib.transactions.index', ['print' => true]) . '&' . http_build_query(Request::all()) }}">Imprimir</a>
                    <br>
                    <br>
                    <table border="1" class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th colspan="3" style="text-align: center;font-size: 16px;">Origen</th>
                                <th>&nbsp;</th>
                                <th colspan="4" style="text-align: center;font-size: 16px;">Destino</th>
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                <th>Doc</th>
                                <th>Cuenta</th>
                                <th>Monto</th>
                                <th>Banco</th>
                                <th>Cuenta</th>
                                <th>Cliente</th>
                                <th>Doc</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr id-trx="{{ $transaction->transactionID }}">
                                    <td>{{ $transaction->transactionExt->customerName }}</td>
                                    <td>{{ $transaction->documentNumber }}</td>
                                    <td>{{ $transaction->accountFromNumber }}</td>
                                    <td>{{ number_format($transaction->amountFrom, 2) }}</td>
                                    @if ($transaction->transactionExt->bank)
                                        <td>{{ $transaction->transactionExt->bank->swiftBankID == '' ? $transaction->transactionExt->bank->referenceInfo : $transaction->transactionExt->bank->swiftBankID }}</td>
                                    @else
                                        <td>BAME</td>
                                    @endif
                                    <td>{{ $transaction->accountToNumber }}</td>
                                    <td>{{ $transaction->transactionExt->achBeneficiaryName }}</td>
                                    <td>{{ $transaction->transactionExt->achBeneficiaryDocumentNumber }}</td>
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
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
