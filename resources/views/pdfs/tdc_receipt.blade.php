@foreach ($credit_cards as $credit_card)
    <page>
        <table style="border: 1px solid black;">
            <tbody>
                <tr>
                    <td colspan="3" rowspan="3">
                        <img src="{{ base_path('\\public\\images\\logo.jpg') }}" style="width: 310px;">
                    </td>
                    <td colspan="3" align="right" width="408">ACUSE DE RECIBO DE TARJETA DE CRÉDITO</td>
                </tr>
                <tr>
                    <td colspan="3" align="right">CONFIDENCIAL</td>
                </tr>
                <tr>
                    <td colspan="3" align="right">ORIGINAL DEL CLIENTE</td>
                </tr>
                <tr>
                    <td colspan="6" align="center">Generado en Fecha {{ format_date($credit_card->getDate()) }} {{ format_time($credit_card->getTime()) }}</td>
                </tr>
                <tr>
                    <td colspan="6" align="center">{{ $credit_card->request_type($request_types) }}: <b>{{ $credit_card->description_tdc_bin($descriptions_tdc_bin) }}</b></td>
                </tr>
                <tr>
                    <td colspan="2">Nombres</td>
                    <td colspan="2"><b>: {{ $credit_card->getNames() }}</b></td>
                    <td colspan="2" rowspan="9" align="right">
                        <img src="{{ $credit_card->getPhoto() }}" style="width: 150px; height: 140px;">
                        <br>
                        Autorizo al Banco Múltiple de las Américas S.A. a activar esta tarjeta de crédito en 24 horas después de recibirla.
                        <br><br><br>
                        ______________________________________
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Apellidos</td>
                    <td colspan="2"><b>: {{ $credit_card->getLastNames() }}</b></td>
                </tr>
                <tr>
                    <td colspan="2">Cédula/Pasaporte</td>
                    <td colspan="2"><b>: {{ $credit_card->getFormattedDocument() }}</b></td>
                </tr>
                <tr>
                    <td colspan="2">Dirección</td>
                    <td colspan="2"><b>: {{ $credit_card->getAddress() }}</b></td>
                </tr>
                <tr>
                    <td colspan="2">Teléfono</td>
                    <td colspan="2">
                        <b>:
                            Res.:
                            {{ $credit_card->getResidentialPhone() }}
                            Cel.:
                            {{ $credit_card->getCellPhone() }}
                            Ofic.:
                            {{ $credit_card->getOfficePhone() }}
                            {{ ($credit_card->getOfficePhoneExtension() == 0) ? '' : 'Ext.: ' . $credit_card->getOfficePhoneExtension() }}
                        </b>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Tarjeta</td>
                    <td colspan="2"><b>: {{ $credit_card->getMaskedCreditCard() }}</b></td>
                </tr>
                <tr>
                    <td colspan="2">Límite de Crédito RD$</td>
                    <td colspan="2"><b>: {{ $credit_card->getDopLimit() }}</b></td>
                </tr>
                <tr>
                    <td colspan="2">Límite de Crédito US$</td>
                    <td colspan="2"><b>: {{ $credit_card->getUsdLimit() }}</b></td>
                    <td colspan="2" align="right" rowspan="2">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Fecha de Corte</td>
                    <td colspan="2"><b>: Los días {{ $credit_card->getCycle() }}</b></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2"></td>
                    <td colspan="2" align="center" style="padding-left: 14px;">Firma</td>
                </tr>
                <tr>
                    <td colspan="6" align="left" border="1" style="padding-bottom: -52px;padding-top: 4px;">
                        Notifica PERDIDA O ROBO Y CONSULTA tus balances llamando a nuestro Centro de Contacto (809)-549-3141 Ext.1 o (809)-200-0819 (Desde el interior sin cargos).
                        Realiza transacciones y consultas de balances a través de Bancamérica Online http://www.bancamerica.com.do
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;" height="40"></td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;"></td>
                </tr>
                <tr style="border: 1px solid black;">
                    <th style="border: 1px solid black;" align="center">Nombre</th>
                    <th style="border: 1px solid black;" align="center">Firma</th>
                    <th style="border: 1px solid black;" align="center" width="48">Cédula/Pasaporte</th>
                    <th style="border: 1px solid black;" align="center">Autorizo Seguridad Vial</th>
                    <th style="border: 1px solid black;" align="center">Representante del Banco</th>
                    <th style="border: 1px solid black;" align="center">Fecha y Hora</th>
                </tr>
                <tr style="border: 1px solid black;">
                    <td colspan="6" align="center" style="padding-bottom: -15px;">
                        Al firmar este Acuse de Recibo quien suscribe da constancia de haber recibido del BANCO la Tarjeta de Crédito especificada más arriba.
                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        <table style="border: 1px solid black;">
            <tbody>
                <tr>
                    <td colspan="3" rowspan="3">
                        <img src="{{ base_path('\\public\\images\\logo.jpg') }}" style="width: 310px;">
                    </td>
                    <td colspan="3" align="right" width="408">ACUSE DE RECIBO DE TARJETA DE CRÉDITO</td>
                </tr>
                <tr>
                    <td colspan="3" align="right">CONFIDENCIAL</td>
                </tr>
                <tr>
                    <td colspan="3" align="right">COPIA DEL BANCO</td>
                </tr>
                <tr>
                    <td colspan="6" align="center">Generado en Fecha {{ format_date($credit_card->getDate()) }} {{ format_time($credit_card->getTime())}}</td>
                </tr>
                <tr>
                    <td colspan="6" align="center">{{ $credit_card->request_type($request_types) }}: <b>{{ $credit_card->description_tdc_bin($descriptions_tdc_bin) }}</b></td>
                </tr>
                <tr>
                    <td colspan="2">Nombres</td>
                    <td colspan="2"><b>: {{ $credit_card->getNames() }}</b></td>
                    <td colspan="2" rowspan="9" align="right">
                        <img src="{{ $credit_card->getPhoto() }}" style="width: 150px; height: 140px;">
                        <br>
                        Autorizo al Banco Múltiple de las Américas S.A. a activar esta tarjeta de crédito en 24 horas después de recibirla.
                        <br><br><br>
                        ______________________________________
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Apellidos</td>
                    <td colspan="2"><b>: {{ $credit_card->getLastNames() }}</b></td>
                </tr>
                <tr>
                    <td colspan="2">Cédula/Pasaporte</td>
                    <td colspan="2"><b>: {{ $credit_card->getFormattedDocument() }}</b></td>
                </tr>
                <tr>
                    <td colspan="2">Dirección</td>
                    <td colspan="2"><b>: {{ $credit_card->getAddress() }}</b></td>
                </tr>
                <tr>
                    <td colspan="2">Teléfono</td>
                    <td colspan="2">
                        <b>:
                            Res.:
                            {{ $credit_card->getResidentialPhone() }}
                            Cel.:
                            {{ $credit_card->getCellPhone() }}
                            Ofic.:
                            {{ $credit_card->getOfficePhone() }}
                            {{ ($credit_card->getOfficePhoneExtension() == 0) ? '' : 'Ext.: ' . $credit_card->getOfficePhoneExtension() }}
                        </b>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Tarjeta</td>
                    <td colspan="2"><b>: {{ $credit_card->getMaskedCreditCard() }}</b></td>
                </tr>
                <tr>
                    <td colspan="2">Límite de Crédito RD$</td>
                    <td colspan="2"><b>: &nbsp;</b></td>
                </tr>
                <tr>
                    <td colspan="2">Límite de Crédito US$</td>
                    <td colspan="2"><b>: &nbsp;</b></td>
                    <td colspan="2" align="right" rowspan="2">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Fecha de Corte</td>
                    <td colspan="2"><b>: Los días {{ $credit_card->getCycle() }}</b></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2"></td>
                    <td colspan="2" align="center" style="padding-left: 14px;">Firma</td>
                </tr>
                <tr>
                    <td colspan="6" align="left" border="1" style="padding-bottom: -52px;padding-top: 4px;">
                        Notifica PERDIDA O ROBO Y CONSULTA tus balances llamando a nuestro Centro de Contacto (809)-549-3141 Ext.1 o (809)-200-0819 (Desde el interior sin cargos).
                        Realiza transacciones y consultas de balances a través de Bancamérica Online http://www.bancamerica.com.do
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;" height="40"></td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;"></td>
                </tr>
                <tr style="border: 1px solid black;">
                    <th style="border: 1px solid black;" align="center">Nombre</th>
                    <th style="border: 1px solid black;" align="center">Firma</th>
                    <th style="border: 1px solid black;" align="center" width="48">Cédula/Pasaporte</th>
                    <th style="border: 1px solid black;" align="center">Autorizo Seguridad Vial</th>
                    <th style="border: 1px solid black;" align="center">Representante del Banco</th>
                    <th style="border: 1px solid black;" align="center">Fecha y Hora</th>
                </tr>
                <tr style="border: 1px solid black;">
                    <td colspan="6" align="center" style="padding-bottom: -15px;">
                        Al firmar este Acuse de Recibo quien suscribe da constancia de haber recibido del BANCO la Tarjeta de Crédito especificada más arriba.
                    </td>
                </tr>
            </tbody>
        </table>
    </page>
@endforeach
