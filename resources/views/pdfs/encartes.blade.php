@extends('layouts.pdf')

@section('title', 'Encartes Generados')

@section('table')

    <table style="border: 1px solid black;">
        <tbody>
            <tr>
                <td colspan="3" rowspan="3">
                    <img src="{{ route('home') . '/images/logo.jpg' }}" style="width: 320px;">
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
                <td colspan="6" align="center">Generado en Fecha {{ date('d/m/Y H:i:s') }}</td>
            </tr>
            <tr>
                <td colspan="6" align="center">Cambio de Tipo: <b>{{ $tarjeta->TIPOD }}</b></td>
            </tr>
            <tr>
                <td colspan="2">Nombres</td>
                <td colspan="2"><b>: {{ $tarjeta->NOMBRE1 }} {{ $tarjeta->NOMBRE2 }}</b></td>
                <td colspan="2" rowspan="9" align="right">
                    <img src="{{ $tarjeta->FOTO }}" style="width: 160px;">
                    <br>
                    Autorizo al Banco Múltiple de las Américas S.A. a activar esta tarjeta de crédito al recibirla.
                    <br><br><br><br>
                    ______________________________________
                </td>
            </tr>
            <tr>
                <td colspan="2">Apellidos</td>
                <td colspan="2"><b>: {{ $tarjeta->APELLIDO1 }} {{ $tarjeta->APELLIDO2 }}</b></td>
            </tr>
            <tr>
                <td colspan="2">Cédula/Pasaporte</td>
                <td colspan="2"><b>: {{ $tarjeta->CEDULA }}</b></td>
            </tr>
            <tr>
                <td colspan="2">Dirección</td>
                <td colspan="2"><b>: {{ $tarjeta->EDIFICIO . ' ' . $tarjeta->BARRIO . ' ' . $tarjeta->CALLE . ' ' . $tarjeta->CIUDAD }}</b></td>
            </tr>
            <tr>
                <td colspan="2">Teléfono</td>
                <td colspan="2">
                    <b>:
                        Res.:
                        {{ '(' . $tarjeta->CODTEL1 . ') ' . $tarjeta->TELRES }}
                        Cel.:
                        {{ '(' . $tarjeta->CODTEL3 . ') ' . $tarjeta->TELCELULAR }}
                        Ofic.:
                        {{ '(' . $tarjeta->CODTEL2 . ') ' . $tarjeta->TELOFICINA }}
                        {{ $tarjeta->EXTENSION == 0 ? '' : 'Ext.: ' . $tarjeta->EXTENSION }}
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="2">Tarjeta</td>
                <td colspan="2"><b>: {{ $tarjeta->TARJETA }}</b></td>
            </tr>
            <tr>
                <td colspan="2">Límite de Crédito RD$</td>
                <td colspan="2"><b>: {{ $tarjeta->CREDITO_RD }}</b></td>
            </tr>
            <tr>
                <td colspan="2">Límite de Crédito US$</td>
                <td colspan="2"><b>: {{ $tarjeta->CREDITO_US }}</b></td>
                <td colspan="2" align="right" rowspan="2">
                </td>
            </tr>
            <tr>
                <td colspan="2">Fecha de Corte</td>
                <td colspan="2"><b>: Los días {{ $tarjeta->CICLO }}</b></td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2" align="center" style="padding-left: 14px;">Firma</td>
            </tr>
            <tr>
                <td colspan="6" align="center" border="1" style="padding-bottom: -52px;padding-top: 4px;">
                    Notifica PERDIDA O ROBO Y CONSULTA tus balances llamando a nuestro Centro de Contacto (809) 549-3141 Ext.: 1.

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
                    <img src="{{ route('home') . '/images/logo.jpg' }}" style="width: 320px;">
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
                <td colspan="6" align="center">Generado en Fecha {{ date('d/m/Y H:i:s') }}</td>
            </tr>
            <tr>
                <td colspan="6" align="center">Cambio de Tipo: <b>{{ $tarjeta->TIPOD }}</b></td>
            </tr>
            <tr>
                <td colspan="2">Nombres</td>
                <td colspan="2"><b>: {{ $tarjeta->NOMBRE1 }} {{ $tarjeta->NOMBRE2 }}</b></td>
                <td colspan="2" rowspan="9" align="right">
                    <img src="{{ $tarjeta->FOTO }}" style="width: 160px;">
                    <br>
                    Autorizo al Banco Múltiple de las Américas S.A. a activar esta tarjeta de crédito al recibirla.
                    <br><br><br><br>
                    ______________________________________
                </td>
            </tr>
            <tr>
                <td colspan="2">Apellidos</td>
                <td colspan="2"><b>: {{ $tarjeta->APELLIDO1 }} {{ $tarjeta->APELLIDO2 }}</b></td>
            </tr>
            <tr>
                <td colspan="2">Cédula/Pasaporte</td>
                <td colspan="2"><b>: {{ $tarjeta->CEDULA }}</b></td>
            </tr>
            <tr>
                <td colspan="2">Dirección</td>
                <td colspan="2"><b>: {{ $tarjeta->EDIFICIO . ' ' . $tarjeta->BARRIO . ' ' . $tarjeta->CALLE . ' ' . $tarjeta->CIUDAD }}</b></td>
            </tr>
            <tr>
                <td colspan="2">Teléfono</td>
                <td colspan="2">
                    <b>:
                        Res.:
                        {{ '(' . $tarjeta->CODTEL1 . ') ' . $tarjeta->TELRES }}
                        Cel.:
                        {{ '(' . $tarjeta->CODTEL3 . ') ' . $tarjeta->TELCELULAR }}
                        Ofic.:
                        {{ '(' . $tarjeta->CODTEL2 . ') ' . $tarjeta->TELOFICINA }}
                        {{ $tarjeta->EXTENSION == 0 ? '' : 'Ext.: ' . $tarjeta->EXTENSION }}
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="2">Tarjeta</td>
                <td colspan="2"><b>: {{ $tarjeta->TARJETA }}</b></td>
            </tr>
            <tr>
                <td colspan="2">Límite de Crédito RD$</td>
                <td colspan="2"><b>: {{ $tarjeta->CREDITO_RD }}</b></td>
            </tr>
            <tr>
                <td colspan="2">Límite de Crédito US$</td>
                <td colspan="2"><b>: {{ $tarjeta->CREDITO_US }}</b></td>
                <td colspan="2" align="right" rowspan="2">
                </td>
            </tr>
            <tr>
                <td colspan="2">Fecha de Corte</td>
                <td colspan="2"><b>: Los días {{ $tarjeta->CICLO }}</b></td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2" align="center" style="padding-left: 14px;">Firma</td>
            </tr>
            <tr>
                <td colspan="6" align="center" border="1" style="padding-bottom: -52px;padding-top: 4px;">
                    Notifica PERDIDA O ROBO Y CONSULTA tus balances llamando a nuestro Centro de Contacto (809) 549-3141 Ext.: 1.

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

@endsection
