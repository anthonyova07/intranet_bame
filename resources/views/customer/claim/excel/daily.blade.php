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
                    <th>No. Reclamación</th>
                    <th>Monto</th>
                    <th>Cliente</th>
                    <th>Identificación</th>
                    <th>Fecha de Apertura</th>
                    <th>Fecha de Resolución</th>
                    <th>Estado</th>
                    <th>Descripción</th>
                    <th>Oficial</th>
                    <th>Sucursal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($claims as $claim)
                    <tr>
                        <td>{{ $claim->claim_number }}</td>
                        <td>{{ number_format($claim->amount, 2) }}</td>
                        <td>{{ $claim->getFullName() }}</td>
                        <td>{{ $claim->identification ?? $claim->passport }}</td>
                        <td>{{ $claim->created_at->format('d/m/Y') }}</td>
                        <td>{{ $claim->closed_date ? $claim->closed_date->format('d/m/Y') : '' }}</td>
                        <td>
                            @if ($claim->is_approved == null)
                                @if ($claim->is_approved == 0)
                                    No Aprobada
                                @endif
                            @else
                                {{ $claim->is_closed ? 'Cerrada' : 'En Proceso' }}
                            @endif
                        </td>
                        <td>{{ $claim->type_description }}</td>
                        <td>{{ $claim->created_by_name }}</td>
                        <td>{{ $claim->response_place_description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('layouts.partials.excel_file')
    </body>
</html>
