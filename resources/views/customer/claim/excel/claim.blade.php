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
                    <th>No. Oficina</th>
                    <th>Tipo de Persona</th>
                    <th>Identificación del Reclamante</th>
                    <th>Nombre del Reclamante</th>
                    <th>Apellidos del Reclamante</th>
                    <th>Estatus</th>
                    <th>Tipo de Producto</th>
                    <th>Fecha de Apertura</th>
                    <th>Descripción de la Reclamación</th>
                    <th>Solución</th>
                    <th>Monto</th>
                    <th>Tipo de Moneda</th>
                    <th>Resultado de la Reclamación</th>
                    <th>Tipo de Reclamación</th>
                    <th>Canal de Distribución</th>
                    <th>Fecha de Resolución</th>
                    <th>Tasa del Día</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($claims as $claim)
                    <tr>
                        <td>{{ $claim->claim_number }}</td>
                        <td>{{ $claim->response_place_code }}</td>
                        <td>{{ $claim->kind_person_code }}</td>
                        <td>{{ $claim->identification ?? $claim->passport }}</td>
                        <td>{{ $claim->names }}</td>
                        <td>{{ $claim->last_names }}</td>
                        <td>{{ $claim->is_closed ? 'TR' : 'PR' }}</td>
                        <td>{{ $claim->product_service_code }}</td>
                        <td>{{ $claim->created_at->format('d/m/Y') }}</td>
                        <td>{{ $claim->type_description }}</td>
                        <td>{{ $claim->closed_comments }}</td>
                        <td>{{ number_format($claim->amount, 2) }}</td>
                        <td>{{ $claim->currency == 'RD$' ? 'DOP' : 'USD' }}</td>
                        <td>{{ $claim->claim_result }}</td>
                        <td>{{ $claim->type_code }}</td>
                        <td>{{ $claim->distribution_channel_code }}</td>
                        <td>{{ $claim->closed_date ? $claim->closed_date->format('d/m/Y') : '' }}</td>
                        <td>{{ $claim->rate_day }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('layouts.partials.excel_file')
    </body>
</html>
