<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    {{-- <title>Reportes de Reclamaciones</title> --}}
</head>
    <body>
        <table border="1" style="font-size: 80%;">
            <thead>
                <tr>
                    <td colspan="2">Bancamérica</td>
                </tr>
                <tr>
                    <td colspan="2">Generado en {{ datetime()->format('d/m/Y h:i:s a') }}</td>
                </tr>
                <tr>
                    <td colspan="2">Generado por {{ session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName() }}</td>
                </tr>
                @if (isset($meta_data))
                    @foreach ($meta_data as $key => $value)
                        <tr>
                            <td colspan="2">{{ $key }}: {{ $value }}</td>
                        </tr>
                    @endforeach
                @endif
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
