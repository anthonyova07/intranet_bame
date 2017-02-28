<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Reclamaciones</title>
</head>
    <body>
        <table border="1" style="font-size: 80%;">
            <thead>
                <tr>
                    <th>Estatus</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($process_requests as $key => $process_request)
                    <tr>
                        @if ($key)
                            <td>{{ $key }}</td>
                        @else
                            <td>Solicitadas</td>
                        @endif
                        <td>{{ $process_request->count() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('layouts.partials.excel_file')
    </body>
</html>
