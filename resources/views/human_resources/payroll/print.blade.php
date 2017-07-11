<!DOCTYPE html>
<html>
<head>
    <title>Comprobante de Nómina - {{ $payroll->name . ' - ' . ($payroll->payroldate->format('d') == 15 ? '1ra Quincena de ' : '2da Quincena') . ' de ' . get_months($payroll->payroldate->format('m')) . ' ' . $payroll->payroldate->format('Y') }}</title>
    <style>
        body {
            font-family: 'Juhl';
            color: #616365;
        }
        /*table {
            border-collapse: collapse;
        }
        th, td {
            border-bottom: 1px solid #CCCCCC;
        }*/
        .fecha {
            border: 1px solid #616365;
            width: 91px;
            padding: 3px;
            margin: 10px;
            border-radius: 6px;
            color: #777;
            text-align: center;
        }
        .fecha_title {
            text-align: left;
            margin-left: -108px;
            font-style: italic;
            font-weight: bold;
            text-decoration: initial;
            position: absolute;
        }
        .header_ncf {
            /*color: #777777;*/
        }
        .header_ncf ul {
            padding: 0 0 0 12px;
        }
        .header_ncf ul li {
            margin-bottom: 12px;
            list-style: none;
        }
        .header_ncf ul li span {
            /*border-bottom: 1px solid #CCCCCC;*/
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
                    <td align="right" width="408">
                        <div style="color: #777777;font-size: 14px;margin-top: 5px;">RNC: 101-11784-2</div>
                        <br>
                        <b style="font-size: 14px;font-style: italic;">Comprobante de Pago de Nómina</b>
                    </td>
                </tr>
                {{-- <tr align="right">
                    <td>
                        <div class="fecha">
                            <div class="fecha_title">Fecha del Recibo</div>
                            {{ $payroll->payroldate->format('d') }}
                            <b>/</b>
                            {{ $payroll->payroldate->format('m') }}
                            <b>/</b>
                            {{ $payroll->payroldate->format('Y') }}
                        </div>
                    </td>
                </tr> --}}
            </tbody>
        </table>
        <div class="header_ncf">
            <ul>
                <li>
                    Código: <span>{{ $payroll->recordcard }}</span>
                </li>
                <li>
                    Nombre: <span>{{ $payroll->name }}</span>
                </li>
                <li>
                    Departamento: <span>{{ $payroll->department }}</span>
                </li>
                <li>
                    Cargo: <span>{{ $payroll->position }}</span>
                </li>
                <li>
                    Identificación: <span>{{ $payroll->identifica }}</span>
                </li>
                <li>
                    Fecha Nómina: <span>{{ $payroll->payroldate->format('d/m/Y') }}</span>
                </li>
            </ul>
        </div>

        <br>

        <table style="width: 100%">
            <thead>
                <tr>
                    <th valign="bottom" align="left" style="width: 10%;">Transacción</th>
                    <th valign="bottom" align="left">Descripción</th>
                    <th valign="bottom" style="width: 12%;">Deducciones</th>
                    <th valign="bottom" style="width: 12%;">Pagos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payroll->details as $detail)
                    <tr class="{{ $detail->amount < 0 ? 'danger':'success' }}">
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $detail->code }}</td>
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $detail->comment }}</td>
                        <td align="right" style="border-bottom: 1px solid #CCCCCC;">{{ $detail->amount < 0 ? number_format($detail->amount, 2) : '' }}</td>
                        <td align="right" style="border-bottom: 1px solid #CCCCCC;">{{ $detail->amount > 0 ? number_format($detail->amount, 2) : '' }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight: bold;">
                    <td></td>
                    <td>Totales</td>
                    <td align="right">{{ number_format($total_discharge, 2) }}</td>
                    <td align="right">{{ number_format($total_ingress, 2) }}</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr style="font-weight: bold;">
                    <td>{{ $last_detail->code }}</td>
                    <td>Monto Neto</td>
                    <td align="center" colspan="2">{{ $last_detail->amount > 0 ? number_format($last_detail->amount, 2) : '' }}</td>
                </tr>
            </tbody>
        </table>

        <div style="text-align: center;margin-top: 100px;">
            <img src="{{ route('home') . '/images/goesgreen.png' }}" style="width: 60px;">
            <p style="font-size: 10px;">
                Por favor, tenga en cuenta su responsabilidad ambiental. Antes de imprimir este documento, pregúntese si realmente necesita una copia en papel.
            </p>
        </div>

        @include('layouts.partials.print_and_exit')
    </body>
</html>
