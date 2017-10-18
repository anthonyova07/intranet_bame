<!DOCTYPE html>
<html>
<head>
    <title>Employee {{ $employee->full_name . ' ( ' . $employee->recordcard . ' )' }}</title>
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
        .header_ncf {
            /*color: #777777;*/
        }
        .header_ncf ul {
            padding: 0 0 0 12px;
        }
        .header_ncf ul li {
            margin-bottom: 12px;
            list-style: none;
        }
        .header_ncf ul li span {
            border-bottom: 1px solid #CCCCCC;
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
                        <b style="font-size: 14px;font-style: italic;">Empleado {{ $employee->full_name . ' ( ' . $employee->recordcard . ' )' }}</b>
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
        <div class="header_ncf" style="float: left;">
            <ul>
                <li>
                    Código: <span>{{ $employee->recordcard }}</span>
                </li>
                <li>
                    Nombre: <span>{{ $employee->full_name }}</span>
                </li>
                <li>
                    Identificación: <span>{{ $employee->identifica }}</span>
                </li>
                <li>
                    Correo: <span>{{ $employee->mail }}</span>
                </li>
                <li>
                    Posición: <span>{{ $employee->position->name }}</span>
                </li>
                <li>
                    Supervisor: <span>{{ $employee->supervisor ? $employee->supervisor->name : '' }}</span>
                </li>
                <li>
                    Fecha Nacimiento: <span>{{ date_create($employee->birthdate)->format('d/m/Y') }}</span>
                </li>
                <li>
                    Fecha Ingreso: <span>{{ date_create($employee->servicedat)->format('d/m/Y') }}</span>
                </li>
                <li>
                    Género: <span>{{ get_gender($employee->gender) }}</span>
                </li>
                <li>
                    Activo: <span>{{ $employee->is_active ? 'Si':'No' }}</span>
                </li>
            </ul>
        </div>

        <div style="float: right;">
            <img style="max-width: 150px;" src="{{ route('home') . '\files\employee_images\\' . get_employee_name_photo($employee->recordcard, $employee->gender) }}">
        </div>

        @include('layouts.partials.print_and_exit')
    </body>
</html>
