<!DOCTYPE html>
<html>
<head>
    <title>Reclamación No {{ $claim->claim_number }}</title>
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
        <table width="100%" border="0">
            <tbody>
                <tr valign="top">
                    <td class="table_td" rowspan="2" style="border: 0;">
                        <img src="{{ route('home') . '/images/logo.jpg' }}" style="width: 220px;">
                    </td>
                    <td class="table_td" align="right" width="408" style="border: 0;">
                        <b style="font-size: 14px;font-style: italic;">Reclamación No. {{ $claim->claim_number }}</b>
                        <br>
                        <div style="color: #777777;font-size: 12px;">Emitido por Bancamérica 101-11784-2</div>
                    </td>
                </tr>
                <tr align="right">
                    <td class="table_td" style="border: 0;">
                        <div class="fecha">
                            <div class="fecha_title">Fecha</div>
                            {{ $datetime->format('d') }}
                            <b>/</b>
                            {{ $datetime->format('m') }}
                            <b>/</b>
                            {{ $datetime->format('Y') }}
                            &nbsp;&nbsp;&nbsp;
                            {{ $datetime->format('h') }}
                            <b>:</b>
                            {{ $datetime->format('i') }}
                            <b>:</b>
                            {{ $datetime->format('s') }}
                            {{ $datetime->format('a') }}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table style="font-size: 100%;">
            <tbody>
                <tr>
                    <td class="table_td" colspan="4" style="text-align: center;font-size: 13px;background-color: #CCC;">
                        <b>Datos Personales del Reclamante</b>
                    </td>
                </tr>
                @if (!$claim->is_company)
                    <tr>
                        <td class="table_td" colspan="2" style="width: 50%"><b>Nombres:</b> {{ $claim->names }}</td>
                        <td class="table_td" colspan="2" style="width: 50%"><b>Apellidos:</b> {{ $claim->last_names }}</td>
                    </tr>
                    <tr>
                        <td class="table_td" colspan="2"><b>No. Cédula:</b> {{ $claim->identification }}</td>
                        <td class="table_td" colspan="2"><b>No. Pasaporte:</b> {{ $claim->passport }}</td>
                    </tr>
                @endif

                @if ($claim->is_company)
                    <tr>
                        <td class="table_td" colspan="2" style="width: 50%"><b>Razón Social:</b> {{ $claim->legal_name }}</td>
                        <td class="table_td" colspan="2" style="width: 50%"><b>RNC:</b> {{ $claim->identification }}</td>
                    </tr>
                @endif

                <tr>
                    <td class="table_td" colspan="{{ $claim->is_company ? '2' : '' }}"><b>Teléfonos:</b></td>
                    @if (!$claim->is_company)
                        <td class="table_td">
                            <b>Residencia: </b> {{ $claim->residential_phone }}
                        </td>
                    @endif
                    <td class="table_td" colspan="{{ $claim->is_company ? '2' : '' }}"><b>Oficina: </b> {{ $claim->office_phone }}</td>
                    @if (!$claim->is_company)
                        <td class="table_td">
                            <b>Celular: </b> {{ $claim->cell_phone }}
                        </td>
                    @endif
                </tr>
                <tr>
                    <td class="table_td" colspan="2"><b>Correo: </b> {{ $claim->mail }}</td>
                    <td class="table_td" colspan="2"><b>Fax: </b> {{ $claim->fax_phone }}</td>
                </tr>
                <tr>
                    <td class="table_td" width="25%"><b>Calle: </b> {{ $claim->street_address }}</td>
                    <td class="table_td" width="25%"><b>Edificio/Residencial: </b> {{ $claim->building_residential }}</td>
                    <td class="table_td" width="25%"><b>Apartamento/Casa: </b> {{ $claim->apartment_number }}</td>
                    <td class="table_td" width="25%"><b>Sector: </b> {{ $claim->sector_address }}</td>
                </tr>
                <tr>
                    <td class="table_td" colspan="2"><b>Ciudad: </b> {{ $claim->city }}</td>
                    <td class="table_td" colspan="2"><b>Provincia: </b> {{ $claim->province }}</td>
                </tr>
            </tbody>
        </table>

        @if ($claim->is_company)
            <br>

            <table style="font-size: 100%;">
                <tbody>
                    <tr>
                        <td class="table_td" colspan="4" style="text-align: center;font-size: 13px;background-color: #CCC;">
                            <b>Datos del Representante</b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%"><b>Nombre Legal:</b> {{ $claim->agent_legal_name }}</td>
                        <td colspan="2" style="width: 50%"><b>Cédula/Pasaporte:</b> {{ $claim->agent_identification }}</td>
                    </tr>
                    <tr>
                        <td><b>Teléfonos:</b></td>
                        <td><b>Residencia: </b> {{ $claim->agent_residential_phone }}</td>
                        <td><b>Oficina: </b> {{ $claim->agent_office_phone }}</td>
                        <td><b>Celular: </b> {{ $claim->agent_cell_phone }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <b>Correo: </b> {{ $claim->agent_mail }}
                        </td>
                        <td colspan="2"><b>Fax: </b> {{ $claim->agent_fax_phone }}</td>
                    </tr>
                </tbody>
            </table>
        @endif

        <br>

        <table style="font-size: 100%;">
            <tbody>
                <tr>
                    <td colspan="2" style="width: 50%"><b>Canal de Distribución:</b> {{ $claim->distribution_channel_description }}</td>
                    <td colspan="2" style="width: 50%"><b>Tipo de Producto:</b> {{ $claim->product_type }}</td>
                </tr>
            </tbody>
        </table>

        <br>

        <table style="font-size: 100%;">
            <tbody>
                <tr>
                    <td class="table_td" colspan="4" style="text-align: center;font-size: 13px;background-color: #CCC;">
                        <b>Datos de la Reclamación</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 50%"><b>Monto Reclamado:</b> {{ $claim->currency . ' ' . number_format($claim->amount, 2) }}</td>
                    <td colspan="2" style="width: 50%"><b>Tipo de Reclamación:</b> {{ $claim->type_description }}</td>
                </tr>
                <tr>
                    <td width="25%"><b>Oficial de la Reclamación:</b> <br> {{ $claim->created_by_name }}</td>
                    <td width="25%"><b>Plazo Estimado de Respuesta:</b> <br> {{ $claim->response_term . ' días' }}</td>
                    <td width="25%"><b>Fecha de Respuesta:</b> <br> {{ $claim->response_date->format('d/m/Y') }}</td>
                    <td width="25%"><b>Lugar para Procurar Respuesta:</b> <br> {{ $claim->response_place_description }}</td>
                </tr>
                <tr>
                    <td colspan="4"><b>Observaciones:</b> {{ $claim->observations }}</td>
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
                        <b>Nota 1:</b>
                        Documentos a adjuntar: Copia de cédula, poder otorgado por el titular (en caso de que se trate de un apoderado), otros documentos que sustenten la reclamación.
                    </td>
                </tr>
                <tr><td class="sign_field"></td></tr>
                <tr><td class="sign_field"></td></tr>
                <tr>
                    <td class="sign_field" style="font-size: 14px;" colspan="2" style="width: 50%">
                        <b>Nota 2:</b>
                        La interposición de una reclamación frente al Banco, no exime al reclamante de cumplir con sus obligaciones de pagar por concepto de consumos o de servicios, los intereses y moras generados con anterioridad o posterioridad al reclamo, ni cualquier otro cargo que haya contrato expresamente con el Banco.
                    </td>
                </tr>
                <tr><td class="sign_field"></td></tr>
                <tr><td class="sign_field"></td></tr>
                <tr>
                    <td class="sign_field" style="font-size: 14px;" colspan="2" style="width: 50%">
                        <b>Nota 3:</b>
                        Los datos que se detallaron anteriormente son declaraciones suministradas por el interesado, quien garantiza la exactitud y veracidad de las mismas.
                    </td>
                </tr>
                <tr><td class="sign_field"></td></tr>
                <tr><td class="sign_field"></td></tr>
                <tr>
                    <td class="sign_field" style="font-size: 14px;" colspan="2" style="width: 50%">
                        <b>Nota 4:</b>
                        Todo cliente tiene derecho a canalizar sus reclamaciones ante Bancamérica.
                    </td>
                </tr>
                <tr><td class="sign_field"></td></tr>
                <tr><td class="sign_field"></td></tr>
                <tr>
                    <td class="sign_field" style="font-size: 14px;" colspan="2" style="width: 50%">
                        <b>Nota 5:</b>
                        Esta reclamación está libre de costos por parte del cliente.
                    </td>
                </tr>
            </tbody>
        </table>

        <table>
            <tbody>
                <tr style="text-align: right;">
                    <td class="sign_field">001-USR-FR<br><span>V3</span></td>
                </tr>
            </tbody>
        </table>

        {{-- @include('layouts.partials.print_and_exit') --}}
    </body>
</html>
