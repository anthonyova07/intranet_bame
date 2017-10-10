<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Clientes Contactados Solicitudes TDC</title>
</head>
    <body>
        <table border="1" style="font-size: 80%;">
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Estatus de Cliente</th>
                    <th>Lista Negra</th>
                    <th>Solicitud</th>
                    <th>Canal</th>
                    <th>Empresa</th>
                    <th>Nombres</th>
                    <th>Nacionalidad</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Sexo</th>
                    <th>Producto Aprobado</th>
                    <th>Limite PreAprobado RD</th>
                    <th>Limite PreAprobado US</th>
                    <th>Teléfono Celular 1</th>
                    <th>Teléfono Celular 2</th>
                    <th>Teléfono Celular 3</th>
                    <th>Teléfono Casa 1</th>
                    <th>Teléfono Casa 2</th>
                    <th>Teléfono Casa 3</th>
                    <th>Teléfono Trabajo 1</th>
                    <th>Teléfono Trabajo 2</th>
                    <th>Teléfono Trabajo 3</th>
                    <th>Teléfono Otro 1</th>
                    <th>Teléfono Otro 2</th>
                    <th>Teléfono Otro 3</th>
                    <th>Campaña</th>
                    <th>Comité</th>
                    <th>Fecha Comité</th>
                    <th>Usuario</th>
                    <th>Nombre Usuario</th>
                    <th>Fecha Creación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->identifica }}</td>
                        @if ($customer->denail)
                            <td>{{ $customer->denail->note }}</td>
                        @else
                            @if ($customer->isRequestDeleted())
                                <td>Eliminada</td>
                            @else
                                <td>Exitoso</td>
                            @endif
                        @endif
                        <td>{{ $customer->is_black ? 'Si':'No' }}</td>
                        <td>{{ $customer->reqnumber }}</td>
                        <td>{{ get_channels($customer->channel) }}</td>
                        <td>{{ $customer->business }}</td>
                        <td>{{ $customer->names }}</td>
                        <td>{{ $customer->nationalit }}</td>
                        <td>{{ $customer->birthdate }}</td>
                        <td>{{ get_gender($customer->gender) }}</td>
                        <td>{{ $customer->producttyp }}</td>
                        <td>{{ $customer->limitrd }}</td>
                        <td>{{ $customer->limitus }}</td>
                        <td>{{ $customer->celular_1 }}</td>
                        <td>{{ $customer->celular_2 }}</td>
                        <td>{{ $customer->celular_3 }}</td>
                        <td>{{ $customer->house_1 }}</td>
                        <td>{{ $customer->house_2 }}</td>
                        <td>{{ $customer->house_3 }}</td>
                        <td>{{ $customer->work_1 }}</td>
                        <td>{{ $customer->work_2 }}</td>
                        <td>{{ $customer->work_3 }}</td>
                        <td>{{ $customer->other_1 }}</td>
                        <td>{{ $customer->other_2 }}</td>
                        <td>{{ $customer->other_3 }}</td>
                        <td>{{ $customer->campaign }}</td>
                        <td>{{ $customer->committee }}</td>
                        <td>{{ $customer->commitdate }}</td>
                        <td>{{ $customer->created_by }}</td>
                        <td>{{ $customer->createname }}</td>
                        <td>{{ $customer->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('layouts.partials.excel_file')
    </body>
</html>
