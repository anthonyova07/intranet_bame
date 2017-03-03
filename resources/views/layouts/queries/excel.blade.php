<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    {{-- <title>Reportes de Reclamaciones</title> --}}
</head>
    <body>
        <table border="1" style="font-size: 80%;">
            <thead>
                @if (count($results))
                    <tr>
                        @foreach ($results[0] as $key => $value)
                            <th>{{ $key }}</th>
                        @endforeach
                    </tr>
                @endif
            </thead>
            <tbody>
                @foreach ($results as $key => $result)
                    <tr>
                        @foreach ($result as $key => $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('layouts.partials.excel_file')
    </body>
</html>
