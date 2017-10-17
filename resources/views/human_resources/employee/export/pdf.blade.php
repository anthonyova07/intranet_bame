<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Empleados</title>
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
    <body style="font-size: 70%">
        <table width="100%" border="0">
            <tbody>
                <tr valign="top">
                    <td rowspan="2">
                        <img src="{{ route('home') . '/images/logo.jpg' }}" style="width: 220px;">
                    </td>
                    <td align="right" width="408">
                        <b style="font-size: 14px;font-style: italic;">
                            Reporte de Empleados (
                            @if ($status == '1')
                                Activos
                            @elseif ($status == '0')
                                Inactivos
                            @else
                                Todos
                            @endif
                            )
                        </b>
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

        <table style="width: 100%">
            <thead>
                <tr>
                    <th valign="bottom" style="">Código</th>
                    <th valign="bottom" style="">Nombre</th>
                    <th valign="bottom" style="width: 90px;">Identificación</th>
                    <th valign="bottom" style="">Correo</th>
                    <th valign="bottom" style="">Posición</th>
                    <th valign="bottom" style="">Supervisor</th>
                    <th valign="bottom" style="">Fecha Nacimiento</th>
                    <th valign="bottom" style="">Fecha Ingreso</th>
                    <th valign="bottom" style="">Género</th>
                    {{-- <th valign="bottom" style="">Activo</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td align="center" style="border-bottom: 1px solid #CCCCCC;">{{ $employee->recordcard }}</td>
                        <td align="left" style="border-bottom: 1px solid #CCCCCC;">{{ $employee->full_name }}</td>
                        <td align="left" style="border-bottom: 1px solid #CCCCCC;">{{ $employee->identifica }}</td>
                        <td align="left" style="border-bottom: 1px solid #CCCCCC;">{{ $employee->mail }}</td>
                        <td align="left" style="border-bottom: 1px solid #CCCCCC;">{{ $employee->position->name }}</td>
                        <td align="left" style="border-bottom: 1px solid #CCCCCC;">{{ $employee->supervisor ? $employee->supervisor->name : '' }}</td>
                        <td align="center" style="border-bottom: 1px solid #CCCCCC;">{{ date_create($employee->birthdate)->format('d/m/Y') }}</td>
                        <td align="center" style="border-bottom: 1px solid #CCCCCC;">{{ date_create($employee->servicedat)->format('d/m/Y') }}</td>
                        <td align="left" style="border-bottom: 1px solid #CCCCCC;">{{ get_gender($employee->gender) }}</td>
                        {{-- <td align="center" style="border-bottom: 1px solid #CCCCCC;">{{ $employee->is_active ? 'Si':'No' }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('layouts.partials.print_and_exit')
    </body>
</html>
