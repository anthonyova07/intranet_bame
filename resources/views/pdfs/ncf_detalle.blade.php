<!DOCTYPE html>
<html>
<head>
    <title>Comprobante Fiscal de {{ $ncf->NOMBRE }}</title>
    <style>
        body {
            font-family: 'Juhl';
        }

        table {
            border-collapse: collapse;
        }

        th, td {
            border-bottom: 1px solid #CCCCCC;
        }
    </style>
</head>
    <body style="font-size: 70%">
        <table width="100%">
            <tbody>
                <tr>
                    <td colspan="3" rowspan="5">
                        <img src="{{ route('home') . '/images/logo.jpg' }}" style="width: 220px;">
                    </td>
                    <td colspan="4" align="center" width="408">
                        <b style="font-size: 15px">Factura con Valor Fiscal</b>
                        Emitido por <b>Bancamérica (101-11784-2)</b>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <b># Factura: </b>
                    </td>
                    <td align="left">
                        {{ $ncf->FACTURA }}
                    </td>
                    <td align="right">
                        <b># Producto: </b>
                    </td>
                    <td align="left">
                        {{ $ncf->PRODUCTO }}
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <b># Cliente: </b>
                    </td>
                    <td align="left">
                        {{ $ncf->CODIGO_CLIENTE }}
                    </td>
                    <td align="right">
                        <b>Nombre: </b>
                    </td>
                    <td align="left">
                        {{ $ncf->NOMBRE }}
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <b>NCF: </b>
                    </td>
                    <td align="left">
                        {{ $ncf->NCF }}
                    </td>
                    <td align="right">
                        <b>Fecha Generado: </b>
                    </td>
                    <td align="left">
                        {{ $ncf->DIA_GENERADO . '/' . $ncf->MES_GENERADO . '/' . $ncf->ANIO_GENERADO }}
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <b>Monto: </b>
                    </td>
                    <td align="left">
                        {{ $ncf->MONTO }}
                    </td>
                    <td align="right">
                        <b>Fecha Proceso: </b>
                    </td>
                    <td align="left">
                        {{ $ncf->MES_PROCESO . '/' . $ncf->ANIO_PROCESO }}
                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        <table style="width: 100%">
            <thead>
                <tr style="font-size: 12px;">
                    <th style="width: 4%;">Cantidad</th>
                    <th align="left">Descripción</th>
                    <th style="width: 8%;">Moneda</th>
                    <th style="width: 5%;">Monto</th>
                    <th style="width: 12%;">Fecha Generado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->CANTIDAD }}</td>
                        <td>{{ $detalle->DESCRIPCION }}</td>
                        <td align="center">{{ $detalle->MONEDA == 'DOP' ? 'RD$':'US$' }}</td>
                        <td align="right">{{ $detalle->MONTO }}</td>
                        <td align="center">{{ $detalle->MES_GENERADO . '/' . $detalle->ANIO_GENERADO }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('partials.print_and_exit')
    </body>
</html>
