<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Solicutdes RRHH</title>
</head>
    <body>
        <table border="1" style="font-size: 80%;">
            <thead>
                <tr>
                    <th># Solicitud</th>
                    <th>Fecha</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Supervisor</th>
                    <th>Tipo de Permiso</th>
                    <th>Fecha Desde</th>
                    <th>Fecha Hasta</th>
                    <th>Hora Desde</th>
                    <th>Hora Hasta</th>
                    <th>Tipo de Solicitud</th>
                    <th>Remunerado</th>
                    <th>Razón del Permiso</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rrhh_requests as $rrhh_request)
                    <tr>
                        <td>{{ $rrhh_request->reqnumber }}</td>
                        <td>{{ $rrhh_request->created_at->format('d/m/Y') }}</td>
                        <td>{{ $rrhh_request->colcode }}</td>
                        <td>{{ $rrhh_request->colname }}</td>
                        <td>{{ $rrhh_request->colsupname }}</td>
                        @if ($rrhh_request->detail->pertype == 'one_day')
                            <td>Un día o menos</td>
                        @elseif ($rrhh_request->detail->pertype == 'multiple_days')
                            <td>Varios días</td>
                        @endif
                        <td>{{ $rrhh_request->detail->perdatfrom->format('d/m/Y') }}</td>
                        @if ($rrhh_request->detail->pertype == 'one_day')
                            <td></td>
                            <td>{{ $rrhh_request->detail->pertimfrom }}</td>
                            <td>{{ $rrhh_request->detail->pertimto }}</td>
                        @elseif ($rrhh_request->detail->pertype == 'multiple_days')
                            <td>{{ $rrhh_request->detail->perdatto->format('d/m/Y') }}</td>
                            <td></td>
                            <td></td>
                        @endif
                        <td>{{ rh_req_types($rrhh_request->reqtype) }}</td>
                        <td>{{ $rrhh_request->detail->paid ? 'Si' : 'No' }}</td>
                        <td>{{ $rrhh_request->detail->reaforabse }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('layouts.partials.excel_file')
    </body>
</html>
