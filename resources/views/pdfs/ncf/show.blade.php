<!DOCTYPE html>
<html>
<head>
    <title>Comprobante Fiscal {{ $ncf->getCustomerNumber() ? ('de ' . $ncf->getName()):'' }}</title>
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
            margin-left: -42px;
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
            border-bottom: 1px solid #CCCCCC;
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
                        <b style="font-size: 14px;font-style: italic;">Factura con Valor Fiscal</b>
                        <br>
                        <div style="color: #777777;font-size: 12px;">Emitido por Bancamérica 101-11784-2</div>
                    </td>
                </tr>
                <tr align="right">
                    <td>
                        <div class="fecha">
                            <div class="fecha_title">Fecha</div>
                            {{ $datetime->format('d') }}
                            <b>/</b>
                            {{ $datetime->format('m') }}
                            <b>/</b>
                            {{ $datetime->format('Y') }}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="header_ncf">
            <ul>
                <li>
                    Factura No.: <span>{{ $ncf->getInvoice() }}</span>
                </li>
                <li>
                    Cliente No.: <span>{{ $ncf->getCustomerNumber() }}</span>
                </li>
                <li>
                    NCF: <span>{{ $ncf->getNcf() }}</span>
                </li>
                <li>
                    Monto: <span>{{ $ncf->getAmount() }}</span>
                </li>
                <li>
                    Producto: <span>{{ $ncf->getProduct() }}</span>
                </li>
                <li>
                    Nombre: <span>{{ $ncf->getName() }}</span>
                </li>
                <li>
                    Fecha Generado: <span>{{ $ncf->getDateGenerated() }}</span>
                </li>
                <li>
                    Fecha de Proceso <span>{{ $ncf->getDateProcess() }}</span>
                </li>
            </ul>
        </div>

        <br>

        <table style="width: 100%">
            <thead>
                <tr>
                    <th valign="bottom" style="width: 4%;">Cantidad</th>
                    <th valign="bottom" align="left">Descripción</th>
                    <th valign="bottom" style="width: 8%;">Moneda</th>
                    <th valign="bottom" style="width: 12%;">Monto</th>
                    <th valign="bottom" style="width: 12%;">Impuesto</th>
                    <th valign="bottom" style="width: 8%;padding-left: 19px;text-align: justify;">Fecha Generado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($details as $detail)
                    <tr>
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $detail->getQuantity() }}</td>
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $detail->getDescription() }}</td>
                        <td align="center" style="border-bottom: 1px solid #CCCCCC;">{{ $detail->getCurrency() == 'DOP' ? 'RD$':'US$' }}</td>
                        <td align="right" style="border-bottom: 1px solid #CCCCCC;">{{ $detail->getAmount() }}</td>
                        <td align="right" style="border-bottom: 1px solid #CCCCCC;">{{ $detail->getTaxAmount() }}</td>
                        <td align="center" style="border-bottom: 1px solid #CCCCCC;">{{ $detail->getDateGenerated() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('layouts.partials.print_and_exit')
    </body>
</html>
