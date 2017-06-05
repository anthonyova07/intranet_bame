<!DOCTYPE html>
<html>
<head>
    <title>Listado de Productos</title>
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
                        <b style="font-size: 14px;font-style: italic;">Historico de Producto</b>
                        <br>
                        <div style="color: #777777;font-size: 12px;">Emitido por Bancamérica 101-11784-2</div>
                    </td>
                </tr>                
            </tbody>
        </table>       

        <br>

        <table style="width: 100%">
            <thead>
                <tr>
                    <th valign="bottom" style="width: 4%;">Producto</th>
                    <th valign="bottom" style="width: 8%;">Tipo</th>
                    <th valign="bottom" style="width: 8%;">Balance</th>
                    <th valign="bottom" style="width: 12%;">Estatus</th>
                    <th valign="bottom" style="width: 12%;">Dia</th>
                    <th valign="bottom" style="width: 12%;">Mes</th>
                    <th valign="bottom" style="width: 12%;">Año</th>
                    <th valign="bottom" style="width: 12%;">Corte</th>
                    <th valign="bottom" style="width: 12%;">Moneda</th>
                    <th valign="bottom" style="width: 12%;">DiaC</th>
                    <th valign="bottom" style="width: 12%;">MesC</th>
                    <th valign="bottom" style="width: 12%;">AnioC</th>
                    <th valign="bottom" style="width: 6%;">Cliente</th>
                    
                </tr>
            </thead>
            <tbody>

                @foreach ($productospdf as $prod)
                    <tr>
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $prod->hisacc }}</td>
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $prod->TipoProducto() }}</td>
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $prod->Balance() }}</td>    
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $prod->hissts }}</td>  
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $prod->hisodd }}</td>    
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $prod->hisodm }}</td>    
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $prod->hisody }}</td>    
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $prod->hiscor }}</td> 
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $prod->hisccy }}</td>    
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $prod->hislpd }}</td>
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $prod->hislpm }}</td>
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $prod->hislpy }}</td>
                        <td style="border-bottom: 1px solid #CCCCCC;">{{ $prod->hiscun }}</td>
                                              
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('layouts.partials.print_and_exit')
    </body>
</html>
