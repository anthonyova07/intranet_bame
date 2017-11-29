<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Mantenimiento Direcciones IBS e ITC</title>
</head>
    <body>
        <table border="1" style="font-size: 80%;">
            <thead>
                <tr>
                    <th>No. Cliente</th>
                    <th>No. Identificación</th>
                    <th>Core</th>
                    <th>IBS Calle</th>
                    <th>IBS No. de Casa / Apartamento</th>
                    <th>IBS País</th>
                    <th>IBS Provincia</th>
                    <th>IBS Ciudad</th>
                    <th>IBS Sector</th>
                    <th>IBS Apartado Postal</th>
                    <th>IBS Código Postal</th>
                    <th>IBS Correo</th>
                    <th>IBS Teléfono Casa</th>
                    <th>IBS Teléfono Oficina</th>
                    <th>IBS Teléfono Fax</th>
                    <th>IBS Teléfono Celular</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($maintenances as $maintenance)
                    <tr>
                        <td>{{ $maintenance->clinumber }}</td>
                        <td>{{ $maintenance->cliident }}</td>
                        <td>{{ strtoupper($maintenance->typecore) }}</td>
                        <td>{{ $maintenance->ibsstreet }}</td>
                        <td>{{ $maintenance->ibsbuhounu }}</td>
                        <td>{{ $maintenance->ibscountry }}</td>
                        <td>{{ $maintenance->ibsprovind }}</td>
                        <td>{{ $maintenance->ibscityd }}</td>
                        <td>{{ $maintenance->ibssectord }}</td>
                        <td>{{ $maintenance->ibspostmail }}</td>
                        <td>{{ $maintenance->ibszipcode }}</td>
                        <td>{{ $maintenance->ibsmail }}</td>
                        <td>{{ $maintenance->ibshouphon }}</td>
                        <td>{{ $maintenance->ibsoffipho }}</td>
                        <td>{{ $maintenance->ibsfaxphon }}</td>
                        <td>{{ $maintenance->ibsmovipho }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('layouts.partials.excel_file')
    </body>
</html>
