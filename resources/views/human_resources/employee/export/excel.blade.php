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
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Identificación</th>
                    <th>Correo</th>
                    <th>Posición</th>
                    <th>Supervisor</th>
                    <th>Fecha Nacimiento</th>
                    <th>Fecha Ingreso</th>
                    <th>Género</th>
                    <th>Activo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->recordcard }}</td>
                        <td>{{ $employee->full_name }}</td>
                        <td>{{ $employee->identifica }}</td>
                        <td>{{ $employee->mail }}</td>
                        <td>{{ $employee->position->name }}</td>
                        <td>{{ $employee->supervisor ? $employee->supervisor->name : '' }}</td>
                        <td>{{ date_create($employee->birthdate)->format('d/m/Y') }}</td>
                        <td>{{ date_create($employee->servicedat)->format('d/m/Y') }}</td>
                        <td>{{ get_gender($employee->gender) }}</td>
                        <td class="text-center">{{ $employee->is_active ? 'Si':'No' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('layouts.partials.excel_file')
    </body>
</html>
