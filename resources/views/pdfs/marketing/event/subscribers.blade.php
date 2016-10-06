<!DOCTYPE html>
<html>
<head>
    <title>Evento {{ $event->title }}</title>
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
                        <b style="font-size: 14px;font-style: italic;">Evento: {{ $event->title }}</b>
                        <br>
                        {{-- <div style="color: #777777;font-size: 12px;">Emitido por Bancamérica 101-11784-2</div> --}}
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

        <br>

        <table style="width: 100%">
            <thead>
                <tr>
                    <th valign="bottom" align="left" style="width: 30%;">Suscriptores</th>
                    <th valign="bottom" align="left" style="width: 20%;">Invitado</th>
                    <th valign="bottom" align="left" style="width: 12%;">Relación</th>
                    <th valign="bottom" style="width: 12%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptions as $subscription)
                    <tr>
                        <td rowspan="{{ $accompanist_subscriptions->where('owner', $subscription->username)->count() + 1 }}" style="border-bottom: 1px solid #CCCCCC;">{{ $subscription->names }}</td>

                        @if (!$accompanist_subscriptions->where('owner', $subscription->username)->count())
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td style="border-bottom: 1px solid #CCCCCC;" align="center" rowspan="{{ $accompanist_subscriptions->where('owner', $subscription->username)->count() }}">{{ $accompanist_subscriptions->where('owner', $subscription->username)->count() + 1 }}</td>
                        @endif
                    </tr>
                    @if ($subscription->accompanists->count())
                        @foreach ($subscription->accompanists as $index => $accompanist)
                            <tr>
                                <td style="border-bottom: 1px solid #CCCCCC;">{{ $accompanist->accompanist->names . ' ' . $accompanist->accompanist->last_names }}</td>
                                <td style="border-bottom: 1px solid #CCCCCC;">{{ get_relationship_types($accompanist->accompanist->relationship) }}</td>
                                @if (!$index)
                                    <td style="border-bottom: 1px solid #CCCCCC;" align="center" rowspan="{{ $subscription->accompanists->count() }}">{{ $subscription->accompanists->count() + 1 }}</td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td align="right" colspan="3" style="font-weight: bold;">Total Empleados: </td>
                    <td align="center" style="font-weight: bold;">{{ $subscriptions->count() }}</td>
                </tr>
                <tr>
                    <td align="right" colspan="3" style="font-weight: bold;">Total Invitados: </td>
                    <td align="center" style="font-weight: bold;">{{ $accompanist_subscriptions->count() }}</td>
                </tr>
                <tr>
                    <td align="right" colspan="3" style="font-weight: bold;">Total: </td>
                    <td align="center" style="font-weight: bold;">{{ $subscriptions->count() + $accompanist_subscriptions->count() }}</td>
                </tr>
            </tfoot>
        </table>

        @if ($format == 'pdf')
            @include('layouts.partials.print_and_exit')
        @endif
    </body>
</html>
