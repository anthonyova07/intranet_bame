<!DOCTYPE html>
<html>
<head>
    <title>Solicitud de Tarjeta No {{ $request_tdc->reqnumber }}</title>
    <style>
        body {
            font-family: 'Juhl';
            color: #616365;
            /*background-image: url({{ route('home') . '/images/bame_background.png' }});
            background-repeat: no-repeat;
            background-size: 100% 100%;*/
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .table_td {
            padding: 3px;
        }
        th, td {
            border-bottom: 1px solid #CCCCCC;
            border-top: 1px solid #CCCCCC;
            border-left: 1px solid #CCCCCC;
            border-right: 1px solid #CCCCCC;
        }
        .fecha {
            border: 1px solid #616365;
            width: 185px;
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
        .sign_field {
            border: 0;
        }
    </style>
</head>
    <body style="font-size: 80%;">
        <table width="100%" border="0" style="page-break-before:always">
            <tbody>
                <tr valign="top">
                    <td class="table_td" rowspan="2" style="border: 0;">
                        <img src="{{ route('home') . '/images/logo.jpg' }}" style="width: 220px;">
                    </td>
                    <td class="table_td" align="right" width="408" style="border: 0;">
                        <b style="font-size: 14px;font-style: italic;">Solicitud de tarjeta No. {{ $request_tdc->reqnumber }}</b>
                        <br>
                        <div style="color: #777777;font-size: 12px;">Emitido por Bancamérica 101-11784-2</div>
                    </td>
                </tr>
                <tr align="right">
                    <td class="table_td" style="border: 0;">
                        <div class="fecha">
                            <div class="fecha_title">Fecha</div>
                            {{ $request_tdc->created_at->format('d') }}
                            <b>/</b>
                            {{ $request_tdc->created_at->format('m') }}
                            <b>/</b>
                            {{ $request_tdc->created_at->format('Y') }}
                            &nbsp;&nbsp;&nbsp;
                            {{ $request_tdc->created_at->format('h') }}
                            <b>:</b>
                            {{ $request_tdc->created_at->format('i') }}
                            <b>:</b>
                            {{ $request_tdc->created_at->format('s') }}
                            {{ $request_tdc->created_at->format('a') }}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table style="font-size: 100%;">
            <tbody>
                <tr>
                    <td class="table_td" colspan="4" style="text-align: center;font-size: 13px;background-color: #CCC;">
                        <b>Datos Personales</b>
                    </td>
                </tr>
                <tr>
                    <td class="table_td" colspan="2" style="width: 50%"><b>Nombre Completo:</b> {{ $request_tdc->names }}</td>
                    <td class="table_td" colspan="2"><b>No. Cédula/Pasaporte:</b> {{ $request_tdc->identifica }}</td>
                </tr>
                <tr>
                    <td class="table_td" colspan="1"><b>Fecha de Nacimiento:</b> {{ date_create($request_tdc->birthdate)->format('d/m/Y') }}</td>
                    <td class="table_td" colspan="1"><b>Nacionalidad:</b> {{ $request_tdc->nationalit }}</td>
                    <td class="table_td" colspan="1"><b>Sexo:</b> {{ get_gender($request_tdc->gender) }}</td>
                    <td class="table_td" colspan="1"><b>Estado Civil:</b> {{ get_marital($request_tdc->maristatus) }}</td>
                </tr>

                <tr>
                    <td class="table_td" colspan="1"><b>Dirección:</b></td>
                    <td class="table_td">
                        <b>Calle: </b> {{ $request_tdc->pstreet }}
                    </td>
                    <td class="table_td">
                        <b>No.: </b> {{ $request_tdc->pnum }}
                    </td>
                    <td class="table_td">
                        <b>Edif.: </b> {{ $request_tdc->pbuilding }}
                    </td>
                </tr>
                <tr>
                    <td class="table_td">
                        <b>Apto.: </b> {{ $request_tdc->papartment }}
                    </td>
                    <td class="table_td">
                        <b>Sector.: </b> {{ $request_tdc->psector }}
                    </td>
                    <td class="table_td">
                        <b>Ciudad.: </b> {{ $request_tdc->pcountry }}
                    </td>
                    <td class="table_td">
                        <b>Email.: </b> {{ $request_tdc->pmail }}
                    </td>
                </tr>
                <tr>
                    <td class="table_td" colspan="2"><b>Teléfonos:</b></td>
                    <td class="table_td">
                        <b>Residencial: </b> {{ $request_tdc->pphone_res }}
                    </td>
                    <td class="table_td">
                        <b>Celular.: </b> {{ $request_tdc->pphone_cel }}
                    </td>
                </tr>
                <tr>
                    <td class="table_td" colspan="4">
                        <b>Nombre del Plástico: </b> {{ $request_tdc->plastiname }}
                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        <table style="font-size: 100%;">
            <tbody>
                <tr>
                    <td class="table_td" colspan="4" style="text-align: center;font-size: 13px;background-color: #CCC;">
                        <b>Datos Laborales</b>
                    </td>
                </tr>
                <tr>
                    <td class="table_td" colspan="2" style="width: 50%">
                        <b>Nombre Empresa:</b> {{ $request_tdc->businename }}
                    </td>
                    <td class="table_td" colspan="1">
                        <b>Cargo:</b> {{ $request_tdc->position }}
                    </td>
                    <td class="table_td" colspan="1">
                        <b>Tiempo Laboral:</b> {{ $request_tdc->workintime }}
                    </td>
                </tr>

                <tr>
                    <td class="table_td" colspan="1"><b>Dirección:</b></td>
                    <td class="table_td">
                        <b>Calle: </b> {{ $request_tdc->lstreet }}
                    </td>
                    <td class="table_td">
                        <b>No.: </b> {{ $request_tdc->lnum }}
                    </td>
                    <td class="table_td">
                        <b>Edif.: </b> {{ $request_tdc->lbuilding }}
                    </td>
                </tr>
                <tr>
                    <td class="table_td">
                        <b>Apto.: </b> {{ $request_tdc->lapartment }}
                    </td>
                    <td class="table_td">
                        <b>Sector.: </b> {{ $request_tdc->lsector }}
                    </td>
                    <td class="table_td">
                        <b>Ciudad.: </b> {{ $request_tdc->lcountry }}
                    </td>
                    <td class="table_td">
                        <b>Email.: </b> {{ $request_tdc->lmail }}
                    </td>
                </tr>
                <tr>
                    <td class="table_td" colspan="1"><b>Teléfonos:</b></td>
                    <td class="table_td">
                        <b>Oficina: </b> {{ $request_tdc->lphone_off }}
                    </td>
                    <td class="table_td">
                        <b>Ext.: </b> {{ $request_tdc->lphone_ext }}
                    </td>
                    <td class="table_td">
                        <b>Fax.: </b> {{ $request_tdc->lphone_fax }}
                    </td>
                </tr>
                <tr>
                    <td class="table_td" colspan="2">
                        <b>Ingresos Mensuales: </b> RD$ {{ number_format($request_tdc->montincome, 2) }}
                    </td>
                    <td class="table_td" colspan="2">
                        <b>Otros Mensuales: </b> RD$ {{ number_format($request_tdc->otheincome, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        <table style="font-size: 100%;">
            <tbody>
                <tr>
                    <td class="table_td" colspan="4" style="text-align: center;font-size: 13px;background-color: #CCC;">
                        <b>Referencias Personales</b>
                    </td>
                </tr>
                <tr>
                    <td class="table_td" colspan="2" style="width: 50%">
                        <b>Nombres y Apellidos:</b>
                    </td>
                    <td class="table_td" colspan="1">
                        <b>Teléfono Residencial:</b>
                    </td>
                    <td class="table_td" colspan="1">
                        <b>Teléfono Celular:</b>
                    </td>
                </tr>
                <tr>
                    <td class="table_td" colspan="2" style="width: 50%">
                        {{ $request_tdc->ref1names }}
                    </td>
                    <td class="table_td" colspan="1">
                        {{ $request_tdc->ref1phores }}
                    </td>
                    <td class="table_td" colspan="1">
                        {{ $request_tdc->ref1phocel }}
                    </td>
                </tr>
                <tr>
                    <td class="table_td" colspan="2" style="width: 50%">
                        {{ $request_tdc->ref2names }}
                    </td>
                    <td class="table_td" colspan="1">
                        {{ $request_tdc->ref2phores }}
                    </td>
                    <td class="table_td" colspan="1">
                        {{ $request_tdc->ref2phocel }}
                    </td>
                </tr>
            </tbody>
        </table>

        <br>
        <br>
        <br>

        <table style="font-size: 80%;width: 100%;">
            <tbody>
                <tr style="text-align: center;">
                    <td class="sign_field">
                        <b>_______________________________________</b>
                        <br>
                        <span style="font-size: 15px;">Firma Gerente</span>
                    </td>

                    <td class="sign_field">
                        <b>_______________________________________</b>
                        <br>
                        <span style="font-size: 15px;">Firma Oficial</span>
                    </td>

                    <td class="sign_field">
                        <b>_______________________________________</b>
                        <br>
                        <span style="font-size: 15px;">Firma Cliente</span>
                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        <table style="font-size: 100%; text-align: justify;">
            <tbody>
                <tr>
                    <td class="sign_field" style="font-size: 14px;" colspan="2" style="width: 50%">
                        Esta solicitud pertenece a la campaña <b>{{ $request_tdc->campaign }}</b>, y esta aprobara por el comité de Crédito <b>#{{ $request_tdc->committee }}</b> de fecha <b>{{ date_create($request_tdc->commitdate)->format('d/m/Y') }}</b>.
                    </td>
                </tr>
            </tbody>
        </table>

        @include('layouts.partials.print_and_exit')
    </body>
</html>
