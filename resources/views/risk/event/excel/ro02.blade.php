<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Eventos de Riesgo</title>
</head>
    <body>
        <table border="1" style="font-size: 80%;">
            <tbody>
                @foreach ($risk_events as $index => $risk_event)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $risk_event->event_code }}</td>
                        <td>{{ $risk_event->business_line->code }}</td>
                        <td>{{ $risk_event->event->code }}</td>
                        <td>{{ $risk_event->descriptio }}</td>
                        <td>{{ $risk_event->currency_type->code }}</td>
                        <td>{{ $risk_event->consequenc }}</td>
                        <td>{{ $risk_event->loss->code }}</td>
                        <td>{{ $risk_event->branch_office->code }}</td>
                        <td>{{ $risk_event->area_department->code }}</td>
                        <td>{{ $risk_event->event_star ? date_create($risk_event->event_star)->format('d/m/Y') : '' }}</td>
                        <td>{{ $risk_event->event_end ? date_create($risk_event->event_end)->format('d/m/Y') : '' }}</td>
                        <td>{{ $risk_event->event_disc ? date_create($risk_event->event_disc)->format('d/m/Y') : '' }}</td>
                        <td>{{ $risk_event->post_date ? date_create($risk_event->post_date)->format('d/m/Y') : '' }}</td>
                        <td>{{ $risk_event->amount_nac }}</td>
                        <td>{{ $risk_event->amount_ori }}</td>
                        <td>{{ $risk_event->amount_ins }}</td>
                        <td>{{ $risk_event->amount_rec }}</td>
                        <td>{{ $risk_event->account }}</td>
                        <td>{{ $risk_event->risklink->code }}</td>
                        <td>{{ $risk_event->distribution_channel->code }}</td>
                        <td>{{ $risk_event->riskfactor->code }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('layouts.partials.excel_file')
    </body>
</html>
