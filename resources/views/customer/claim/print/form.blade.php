<!DOCTYPE html>
<html>
<head>
    <title>Reclamación No {{ $form->claim->claim_number }}</title>
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
            width: 170px;
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
                    <td class="table_td" rowspan="2" style="border: 0;">
                        <img src="{{ route('home') . '/images/logo.jpg' }}" style="width: 280px;">
                    </td>
                    <td class="table_td" align="right" width="408" style="border: 0;">
                        <b style="font-size: 14px;font-style: italic;">Reclamación No. {{ $form->claim->claim_number }}</b>
                        <br>
                        <div style="color: #777777;font-size: 12px;">Emitido por Bancamérica 101-11784-2</div>
                    </td>

                    @if (in_array($form->form_type, ['FRA', 'CON']))

                        <td rowspan="2" valign="top" width="158" style="text-align: center;font-size: 20px;font-weight: bold;border: 0;">
                            <img src="{{ route('home') . '/images/visa.png' }}" style="width: 140px;margin-bottom: -28px;margin-top: -21px;">
                            <br>
                            <div>
                                @if (in_array($form->form_type, ['CON']))
                                    Carta de
                                @endif

                                @if (in_array($form->form_type, ['FRA']))
                                    Reclamación
                                @endif
                            </div>
                            <div style="margin-top: -9px;">
                                @if (in_array($form->form_type, ['CON']))
                                    Reclamación
                                @endif

                                @if (in_array($form->form_type, ['FRA']))
                                    por Fraude
                                @endif
                            </div>
                        </td>

                    @endif
                </tr>
                <tr align="right">
                    <td class="table_td" style="border: 0;">
                        <div class="fecha" style="margin-top: 0px;margin-right: 0px;">
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

        @if (in_array($form->form_type, ['CAI']))

            <h3 style="margin-bottom: 0px;">Información General</h3>
            <br>
            <table style="width: 100%;margin-left: 10px;">
                <tbody>
                    <tr>
                        <td colspan="2"><b>Nombre del Cliente: </b> {{ $form->claim->names . ' ' . $form->claim->last_names }}</td>
                        <td colspan="2"><b>Tipo de Producto:</b> {{ $form->claim->product_type }}</td>
                        <td colspan="2"><b>Producto:</b> {{ $form->claim->getProduct() }}</td>
                        <td colspan="2"><b>Tipo de Moneda:</b> {{ $form->claim->currency }}</td>
                    </tr>
                </tbody>
            </table>

            <br>

            <table style="width: 80%;margin-left: 10px;border-bottom: 1px solid #ccc;margin: auto;">
                <tbody>
                    <tr>
                        <td style="border-bottom: 1px solid #ccc;" colspan="2"><b>Capital: </b> {{ number_format($form->capital, 2) }}</td>
                        <td style="border-bottom: 1px solid #ccc;" colspan="2"><b>% Descuento:</b> {{ $form->capital_discount_percent }}</td>
                        <td style="border-bottom: 1px solid #ccc;" colspan="2"><b>Total:</b> {{ number_format($form->capital_total, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #ccc;" colspan="2"><b>Interés: </b> {{ number_format($form->interest, 2) }}</td>
                        <td style="border-bottom: 1px solid #ccc;" colspan="2"><b>% Descuento:</b> {{ $form->interest_discount_percent }}</td>
                        <td style="border-bottom: 1px solid #ccc;" colspan="2"><b>Total:</b> {{ number_format($form->interest_total, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #ccc;" colspan="2"><b>Mora: </b> {{ number_format($form->arrears, 2) }}</td>
                        <td style="border-bottom: 1px solid #ccc;" colspan="2"><b>% Descuento:</b> {{ $form->arrears_discount_percent }}</td>
                        <td style="border-bottom: 1px solid #ccc;" colspan="2"><b>Total:</b> {{ number_format($form->arrears_total, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #ccc;" colspan="2"><b>Cargos: </b> {{ number_format($form->charges, 2) }}</td>
                        <td style="border-bottom: 1px solid #ccc;" colspan="2"><b>% Descuento:</b> {{ $form->charges_discount_percent }}</td>
                        <td style="border-bottom: 1px solid #ccc;" colspan="2"><b>Total:</b> {{ number_format($form->charges_total, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #ccc;" colspan="2"><b>Otros Cargos: </b> {{ number_format($form->others_charges, 2) }}</td>
                        <td style="border-bottom: 1px solid #ccc;" colspan="2"><b>% Descuento:</b> {{ $form->others_charges_discount_percent }}</td>
                        <td style="border-bottom: 1px solid #ccc;" colspan="2"><b>Total:</b> {{ number_format($form->others_charges_total, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;" colspan="2"><b>Nivel de Atraso: </b> {{ $form->arrears_level }} días</td>
                        <td></td>
                        <td style="text-align: left;" colspan="2"><b>Total:</b> {{ number_format($form->total_to_reverse, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <table style="font-size: 80%;">
                <tbody>
                    <tr>
                        <td>
                            Comentarios: {{ $form->comments }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <br>
            <br>

        @endif

        @if (in_array($form->form_type, ['CON']))

            <table style="font-size: 80%;">
                <tbody>
                    <tr>
                        <td class="sign_field" style="" colspan="2" style="width: 50%">
                            <b>Estimados Señores:</b>
                            Por medio del presente deseo reclamar las transacciones que detallo a continuación, con la finalidad de que regularicen mi cuenta con la mayor brevedad posible o me suministren información suficiente para aclarar mis dudas.
                        </td>
                    </tr>
                    <tr>
                        <td class="sign_field" style="" colspan="2" style="width: 50%">
                            <b>Distinguish Sirs:</b>
                            By means of this letter a wish to dispute the fallowing transactions, and that my account by credited as soon as possible or that you supply sufficient information so there I can clear my doubts.
                        </td>
                    </tr>
                </tbody>
            </table>

        @endif

        @if (in_array($form->form_type, ['FRA', 'CON']))

            <div class="header_ncf">
                <h3>Datos del Cliente / Client Information</h3>
                <ul>
                    <li>
                        Nombre del Tarjetahabiente Principal (Principal Cardholder Name): <span>{{ $form->claim->names . ' ' . $form->claim->last_names }}</span>
                    </li>
                    <li>
                        Número de Tarjeta de Crédito (CC Number): <span>{{ $form->claim->getProduct() }}</span>
                    </li>
                    <li>
                        Número de Contacto con el Tarjetahabiente (Cardholder Contact Number): <span>{{ $form->claim->getOnePhoneNumber() }}</span>
                    </li>
                </ul>
            </div>

            <h3>Transacciones / Transactions</h3>

            <table style="width: 100%;margin-left: 10px;">
                <thead>
                    <tr>
                        <th valign="bottom" style="text-align: left;">Fecha Trans. / Trans. Date</th>
                        <th valign="bottom" style="text-align: left;">Comercio / Merchant Name</th>
                        <th valign="bottom" style="text-align: center;">Cantidad / Amount (RD$ / US$)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($form->transactions as $transaction)
                        <tr>
                            <td style="border-bottom: 1px solid #CCCCCC;">{{ $transaction->transaction_date->format('d/m/Y h:i:s a') }}</td>
                            <td style="border-bottom: 1px solid #CCCCCC;">{{ $transaction->merchant_name }}</td>
                            <td align="center" style="border-bottom: 1px solid #CCCCCC;">{{ 'RD$ ' . number_format($transaction->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            @if (in_array($form->form_type, ['FRA']))

                Espero que ustedes hagan la correción necesaria.

                <br>

                Hoping you make the appropriate corrections to my account number and open an investigation regarding this case.

            @endif

        @endif

        @if (in_array($form->form_type, ['FRA', 'CON']))

            <div class="header_ncf">
                <h3>Tipo de Reclamo / Claim Type</h3>

                @if (in_array($form->form_type, ['CON']))

                    <ul>
                        <li>
                            <b>{{ $form->claim_es_name }}</b>
                            <br>
                            {{ $form->claim_es_detail }}
                            <br>
                            {{ $form->claim_es_detail_2 }}
                        </li>
                        <li>
                            <b>{{ $form->claim_en_name }}</b>
                            <br>
                            {{ $form->claim_en_detail }}
                            <br>
                            {{ $form->claim_en_detail_2 }}
                        </li>
                    </ul>

                @endif

                @if (in_array($form->form_type, ['FRA']))

                    Por este medio certifico que no he realizado ninguna de las transacciones detalladas a continuación; y que en todo momento he tenido la tarjeta en mi poder; por lo que considero que dichos consumos son fraudulentos y solicito la reversión de lo mismo.

                    <br>
                    <br>

                    Hereby I confirm that, neither anyone, not I authorizes to use my card, engaged in the transaction listed below using my account number, and I had my credit card at all the time with me.

                @endif

            </div>

            <h3 style="margin-bottom: 0px;">Datos de Oficial del Banco</h3>
            <table style="width: 100%;margin-left: 10px;">
                <tbody>
                    <tr>
                        <td colspan="2"><b>Nombre y Apellido: </b> {{ $form->created_by_name }}</td>
                        <td colspan="2"><b>Teléfono:</b> {{ $form->created_by_phone }}</td>
                        <td colspan="2"><b>Fecha de Respuesta:</b> {{ $form->response_date->format('d/m/Y') }}</td>
                    </tr>
                </tbody>
            </table>

            <table style="font-size: 80%;margin-top: 5px;">
                <tbody>
                    <tr>
                        <td class="sign_field" style="" colspan="2" style="width: 50%">
                            <b>IMPORTANTE:</b>
                            <ol>
                                <li>Este reclamo no lo exime de sus obligaciones, pagos o cargos, sucedidos con posterioridad al mismo.</li>
                                <li>En caso de que la respuesta no sea favorable o no haya sido entregada dentro de los 30 días siguientes a la reclamación, usted tiene derecho a presentar la misma, ante la Oficina de Servicio y Protección al Usuario (PROUSUARIO).</li>
                                <li>Esta reclamación esta libre de costos por parte del cliente.</li>
                            </ol>
                        </td>
                    </tr>
                    <tr>
                        <td class="sign_field" style="" colspan="2" style="width: 50%">
                            <b>IMPORTANT:</b>
                            <ol>
                                <li>The interposition of a claim does not exempt you from the fulfillment of your obligations, payments or charges made subsequently to the claim.</li>
                                <li>In case the response is not favorable or has not been delivered in 30 days fallowing the claim, you have the right to present it, to the Users Protection and Service Office (PROUSUARIO).</li>
                                <li>Claims are free of charge.</li>
                            </ol>
                        </td>
                    </tr>
                </tbody>
            </table>

        @endif

        <br>

        <table style="font-size: 80%;width: 100%;">
            <tbody>
                <tr style="text-align: center;">
                    <td class="sign_field" colspan="2" style="width: 50%;">
                        <b>__________________________________________________</b>
                        <br>
                        <span style="font-size: 15px;">Firma por el Banco</span>
                    </td>

                    @if (in_array($form->form_type, ['CAI']))

                        <td class="sign_field" colspan="2" style="width: 50%;">
                            <b>__________________________________________________</b>
                            <br>
                            <span style="font-size: 15px;">Firma del Gerente</span>
                        </td>

                    @endif

                    <td class="sign_field" colspan="2" style="width: 50%;">
                        <b>__________________________________________________</b>
                        <br>
                        <span style="font-size: 15px;">Firma de Cliente (Cardholder Signature)</span>
                    </td>
                </tr>
            </tbody>
        </table>

        @include('layouts.partials.print_and_exit')
    </body>
</html>
