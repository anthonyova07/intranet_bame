<!DOCTYPE html>
<html>
<head>
    <title>Tipo de Transacción: "{{ $transaction_type->longName }}"</title>
    <style>
        body {
            font-family: 'Juhl';
            color: #616365;
        }
        table {
            border-collapse: collapse;
        }
        th, td {
            border-bottom: 1px solid #CCCCCC;
            text-align: left;
        }
        .fecha {
            border: 1px solid #616365;
            width: 150px;
            padding: 3px;
            margin: 10px;
            border-radius: 6px;
            color: #777;
            text-align: center;
        }
        .fecha_title {
            text-align: left;
            margin-left: -42px;
            font-style: italic;
            font-weight: bold;
            text-decoration: initial;
            position: absolute;
        }
    </style>
</head>
    <body style="font-size: 80%">
        <table width="100%" border="0">
            <tbody>
                <tr valign="top">
                    <td rowspan="2">
                        <img src="{{ route('home') . '/images/logo.jpg' }}" style="width: 220px;">
                    </td>
                    <td style="text-align: right;" width="408">
                        <b style="font-size: 14px;font-style: italic;">Tipo de Transacción: "{{ $transaction_type->longName }}"</b>
                        <br>
                        {{-- <div style="color: #777777;font-size: 12px;">Emitido por Bancamérica 101-11784-2</div> --}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fecha" style="float: right;">
                            <div class="fecha_title">Fecha</div>
                            {{ $datetime->format('d') }}
                            <b>/</b>
                            {{ $datetime->format('m') }}
                            <b>/</b>
                            {{ $datetime->format('Y') }}
                            &nbsp;
                            {{ $datetime->format('h') }}
                            <b>:</b>
                            {{ $datetime->format('i') }}
                            <b>:</b>
                            {{ $datetime->format('s') }}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        <table style="width: 100%; font-size: 80%;">
            <thead>
                <tr>
                    <th colspan="3" style="text-align: center;font-size: 16px;border-right: 1px solid #CCCCCC;">Origen</th>
                    <th>&nbsp;</th>
                    <th colspan="4" style="text-align: center;font-size: 16px;border-left: 1px solid #CCCCCC;">Destino</th>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <th>Doc</th>
                    <th>Cuenta</th>
                    <th style="text-align: center;">Monto</th>
                    <th style="text-align: center;">Banco</th>
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
                        <td style="text-align: right;">{{ number_format($transaction->amountFrom, 2) }}</td>
                        @if ($transaction->transactionExt->bank)
                            <td style="text-align: center;">{{ $transaction->transactionExt->bank->referenceInfo == '' ? $transaction->transactionExt->bank->swiftBankID : $transaction->transactionExt->bank->referenceInfo}}</td>
                        @else
                            <td style="text-align: center;">BAME</td>
                        @endif
                        <td>{{ $transaction->accountToNumber }}</td>
                        <td>{{ $transaction->transactionExt->achBeneficiaryName }}</td>
                        <td>{{ $transaction->transactionExt->achBeneficiaryDocumentNumber }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="font-weight: bold;text-align: right;">Total: </td>
                    <td style="font-weight: bold;text-align: right;">{{ number_format($transactions->sum('amountFrom'), 2) }}</td>
                    <td colspan="4">&nbsp;</td>
                </tr>
            </tfoot>
        </table>

        @include('layouts.partials.print_and_exit')
    </body>
</html>
