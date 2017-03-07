<!DOCTYPE html>
<html>
<head>
    <title>Solicitudes de Proceso</title>
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
                        <b style="font-size: 14px;font-style: italic;">Solicitudes de Proceso</b>
                        <br>
                        {{-- <div style="color: #777777;font-size: 12px;">Emitido por Bancamérica 101-11784-2</div> --}}
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

        <br>

        <table style="width: 100%">
            <thead>
                <tr>
                    <th rowspan="2" valign="middle" align="center" style="width: 30%;">Tipo de Solicitud</th>
                    <th rowspan="2" valign="middle" align="center" style="width: 20%;">Cantidad de Solicitudes</th>
                    <th colspan="2" valign="middle" align="center" style="width: 12%;">Estado</th>
                </tr>
                <tr>
                    <th valign="middle" align="center" style="width: 12%;">Status</th>
                    <th valign="middle" align="center" style="width: 12%;">Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($process_requests->groupBy('reqtype') as $request_type => $process_request)
                    <tr>
                        <td rowspan="4" style="border-bottom: 1px solid #CCCCCC;" align="center">{{ $request_type }}</td>
                        <td rowspan="4" style="border-bottom: 1px solid #CCCCCC;" align="center">{{ $process_request->count() }}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #CCCCCC;" align="center">Aprobada</td>
                        <td style="border-bottom: 1px solid #CCCCCC;" align="center">{{ $process_request->where('reqstatus', 'Aprobada')->count() }}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #CCCCCC;" align="center">Pendiente</td>
                        <td style="border-bottom: 1px solid #CCCCCC;" align="center">{{ $process_request->where('reqstatus', 'Pendiente')->count() }}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #CCCCCC;" align="center">Finalizada</td>
                        <td style="border-bottom: 1px solid #CCCCCC;" align="center">{{ $process_request->where('reqstatus', 'Finalizada')->count() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('layouts.partials.print_and_exit')
    </body>
</html>
