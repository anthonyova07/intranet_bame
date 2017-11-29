<!DOCTYPE html>
<html>
<head>
    <title>Mantenimiento del Cliente No {{ $m->clinumber }}</title>
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
                        <b style="font-size: 14px;font-style: italic;">Mantenimiento del Cliente. {{ $m->clinumber }}</b>
                        <br>
                        <div style="color: #777777;font-size: 12px;">Realizado por {{ $m->createname }}</div>
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
                        <b>Datos del Cliente ({{ $m->clinumber }})</b>
                    </td>
                </tr>
                <tr>
                    <td class="table_td" colspan="4" style="width: 50%"><b>Identificación:</b> {{ $m->cliident }}</td>
                </tr>
            </tbody>
        </table>

        @if ($m->typecore == 'ibs')
            <br>

            <table style="font-size: 100%;">
                <tbody>
                    <tr>
                        <td colspan="2" style="width: 50%"><b>Calle:</b> {{ $m->ibsstreet }}</td>
                        <td colspan="2" style="width: 50%"><b>No. de Casa / Apartamento:</b> {{ $m->ibsbuhounu }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%"><b>País:</b> {{ $m->ibscountry }}</td>
                        <td colspan="2" style="width: 50%"><b>Provincia:</b> {{ $m->ibsprovind }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%"><b>Ciudad:</b> {{ $m->ibscityd }}</td>
                        <td colspan="2" style="width: 50%"><b>Sector:</b> {{ $m->ibssectord }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%"><b>Apartado Postal:</b> {{ $m->ibsposmail }}</td>
                        <td colspan="2" style="width: 50%"><b>Código Postal:</b> {{ $m->ibszipcode }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="width: 50%"><b>Correo:</b> {{ $m->ibsmail }}</td>
                    </tr>
                </tbody>
            </table>

            <br>

            <table style="font-size: 100%;">
                <tbody>
                    <tr>
                        <td class="table_td" colspan="4" style="text-align: center;font-size: 13px;background-color: #CCC;">
                            <b>Contacto</b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%"><b>Teléfono Casa:</b> {{ $m->ibshouphon }}</td>
                        <td colspan="2" style="width: 50%"><b>Teléfono Oficina:</b> {{ $m->ibsoffipho }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%"><b>Teléfono Fax:</b> {{ $m->ibsfaxphon }}</td>
                        <td colspan="2" style="width: 50%"><b>Teléfono Celular:</b> {{ $m->ibsmovipho }}</td>
                    </tr>
                </tbody>
            </table>
        @endif

        @if ($m->typecore == 'itc')
            <br>

            <table style="font-size: 100%;">
                <tbody>
                    <tr>
                        <td class="table_td" colspan="4" style="text-align: center;font-size: 13px;background-color: #CCC;">
                            <b>
                                Dirección de la/s TDC/s
                                @foreach (explode(',', $m->tdcnumber) as $index => $tdc)
                                    {{ masked_tdc_number($tdc) }}
                                    @if (count(explode(',', $m->tdcnumber)) != ($index + 1))
                                        &nbsp;-&nbsp;
                                    @endif
                                @endforeach
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="table_td" colspan="2" style="text-align: center;font-size: 13px;background-color: #CCC;">
                            <b>ITC Dirección Residencia</b>
                        </td>
                        <td class="table_td" colspan="2" style="text-align: center;font-size: 13px;background-color: #CCC;">
                            <b>ITC Dirección Estado Cuenta</b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1" style="width: 25%"><b>País:</b> {{ $m->itc_dir_one->itccountrd }}</td>
                        <td colspan="1" style="width: 25%"><b>Región:</b> {{ $m->itc_dir_one->itcregiond }}</td>
                        <td colspan="1" style="width: 25%"><b>País:</b> {{ $m->itc_dir_two->itccountrd }}</td>
                        <td colspan="1" style="width: 25%"><b>Región:</b> {{ $m->itc_dir_two->itcregiond }}</td>
                    </tr>
                    <tr>
                        <td colspan="1" style="width: 25%"><b>Provincia:</b> {{ $m->itc_dir_one->itcprovind }}</td>
                        <td colspan="1" style="width: 25%"><b>Ciudad:</b> {{ $m->itc_dir_one->itccityd }}</td>
                        <td colspan="1" style="width: 25%"><b>Provincia:</b> {{ $m->itc_dir_two->itcprovind }}</td>
                        <td colspan="1" style="width: 25%"><b>Ciudad:</b> {{ $m->itc_dir_two->itccityd }}</td>
                    </tr>
                    <tr>
                        <td colspan="1" style="width: 25%"><b>Municipio:</b> {{ $m->itc_dir_one->itcmunicid }}</td>
                        <td colspan="1" style="width: 25%"><b>Sector:</b> {{ $m->itc_dir_one->itcsectord }}</td>
                        <td colspan="1" style="width: 25%"><b>Municipio:</b> {{ $m->itc_dir_two->itcmunicid }}</td>
                        <td colspan="1" style="width: 25%"><b>Sector:</b> {{ $m->itc_dir_two->itcsectord }}</td>
                    </tr>
                    <tr>
                        <td colspan="1" style="width: 25%"><b>Barrio:</b> {{ $m->itc_dir_one->itcneighod }}</td>
                        <td colspan="1" style="width: 25%"><b>Calle:</b> {{ $m->itc_dir_one->itcstreetd }}</td>
                        <td colspan="1" style="width: 25%"><b>Barrio:</b> {{ $m->itc_dir_two->itcneighod }}</td>
                        <td colspan="1" style="width: 25%"><b>Calle:</b> {{ $m->itc_dir_two->itcstreetd }}</td>
                    </tr>
                    <tr>
                        <td colspan="1" style="width: 25%"><b>Nombre Edificio:</b> {{ $m->itc_dir_one->itcbuiname }}</td>
                        <td colspan="1" style="width: 25%"><b>Manzana:</b> {{ $m->itc_dir_one->itcblock }}</td>
                        <td colspan="1" style="width: 25%"><b>Nombre Edificio:</b> {{ $m->itc_dir_two->itcbuiname }}</td>
                        <td colspan="1" style="width: 25%"><b>Manzana:</b> {{ $m->itc_dir_two->itcblock }}</td>
                    </tr>
                    <tr>
                        <td colspan="1" style="width: 25%"><b>No. Casa/Apartamento:</b> {{ $m->itc_dir_one->itchousnum }}</td>
                        <td colspan="1" style="width: 25%"><b>KM:</b> {{ $m->itc_dir_one->itckm }}</td>
                        <td colspan="1" style="width: 25%"><b>No. Casa/Apartamento:</b> {{ $m->itc_dir_two->itchousnum }}</td>
                        <td colspan="1" style="width: 25%"><b>KM:</b> {{ $m->itc_dir_two->itckm }}</td>
                    </tr>
                    <tr>
                        <td colspan="1" style="width: 25%"><b>Zona Postal:</b> {{ $m->itc_dir_one->itcposzone }}</td>
                        <td colspan="1" style="width: 25%"><b>Apartado Postal:</b> {{ $m->itc_dir_one->itcposmail }}</td>
                        <td colspan="1" style="width: 25%"><b>Zona Postal:</b> {{ $m->itc_dir_two->itcposzone }}</td>
                        <td colspan="1" style="width: 25%"><b>Apartado Postal:</b> {{ $m->itc_dir_two->itcposmail }}</td>
                    </tr>
                    <tr>
                        <td colspan="1" style="width: 25%"><b>Entre Cuales Calles 1:</b> {{ $m->itc_dir_one->itcinstre1 }}</td>
                        <td colspan="1" style="width: 25%"><b>Entre Cuales Calles 2:</b> {{ $m->itc_dir_one->itcinstre2 }}</td>
                        <td colspan="1" style="width: 25%"><b>Entre Cuales Calles 1:</b> {{ $m->itc_dir_two->itcinstre1 }}</td>
                        <td colspan="1" style="width: 25%"><b>Entre Cuales Calles 2:</b> {{ $m->itc_dir_two->itcinstre2 }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%"><b>Intrucción Especial:</b> {{ $m->itc_dir_one->itcspeinst }}</td>
                        <td colspan="2" style="width: 50%"><b>Intrucción Especial:</b> {{ $m->itc_dir_two->itcspeinst }}</td>
                    </tr>
                </tbody>
            </table>

            <br>

            <table style="font-size: 100%;">
                <tbody>
                    <tr>
                        <td class="table_td" colspan="4" style="text-align: center;font-size: 13px;background-color: #CCC;">
                            <b>Contacto</b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%"><b>Teléfono Principal:</b> {{ $m->itc_dir_one->getMainPhone() }}</td>
                        <td colspan="2" style="width: 50%"><b>Teléfono Principal:</b> {{ $m->itc_dir_two->getMainPhone() }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%"><b>Teléfono Secundario:</b> {{ $m->itc_dir_one->getSecundaryPhone() }}</td>
                        <td colspan="2" style="width: 50%"><b>Teléfono Secundario:</b> {{ $m->itc_dir_two->getSecundaryPhone() }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%"><b>Celular Principal:</b> {{ $m->itc_dir_one->getMainCel() }}</td>
                        <td colspan="2" style="width: 50%"><b>Celular Principal:</b> {{ $m->itc_dir_two->getMainCel() }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%"><b>Celular Secundario:</b> {{ $m->itc_dir_one->getSecundaryCel() }}</td>
                        <td colspan="2" style="width: 50%"><b>Celular Secundario:</b> {{ $m->itc_dir_two->getSecundaryCel() }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%"><b>Fax:</b> {{ $m->itc_dir_one->getFax() }}</td>
                        <td colspan="2" style="width: 50%"><b>Fax:</b> {{ $m->itc_dir_two->getFax() }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%"><b>Correo Electronico:</b> {{ $m->itc_dir_one->itcmail }}</td>
                        <td colspan="2" style="width: 50%"><b>Correo Electronico:</b> {{ $m->itc_dir_two->itcmail }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%"><b>Formas de Envio de Estados:</b> {{ ways_sending_statement_itc($m->itc_dir_one->waysendsta) }}</td>
                        <td colspan="2" style="width: 50%"><b>Formas de Envio de Estados:</b> {{ ways_sending_statement_itc($m->itc_dir_two->waysendsta) }}</td>
                    </tr>
                </tbody>
            </table>
        @endif

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

        @include('layouts.partials.print_and_exit')
    </body>
</html>
