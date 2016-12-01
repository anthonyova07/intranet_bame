<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Transacciones ITC</title>
</head>
    <body>
        <table border="1" style="font-size: 80%;">
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
                    <th>BIN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ '*' . $transaction->getCreditCard() }}</td>
                        @if ($transaction->creditcard)
                            <td>{{ $transaction->creditcard->getIdentification() }}</td>
                            <td>{{ $transaction->creditcard->getPlasticName() }}</td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        <td>{{ $transaction->getDescription() }}</td>
                        <td>{{ $transaction->getCurrency() == '214' ? 'DOP' : 'USD' }}</td>
                        <td>{{ number_format($transaction->getAmount(), 2) }}</td>
                        <td>{{ $transaction->transaction_type->getDescription() }}</td>
                        <td>{{ $transaction->transaction_concep->getDescription() }}</td>
                        <td>{{ $transaction->getProcessDate() }}</td>
                        <td>{{ $transaction->getTransactionDate() }}</td>
                        <td>{{ substr($transaction->getCreditCard(), 0, 6) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('layouts.partials.excel_file')
    </body>
</html>
