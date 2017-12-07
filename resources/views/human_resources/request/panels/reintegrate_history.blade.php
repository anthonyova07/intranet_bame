<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Histórico de cambios de reintegro</h3>
            </div>

            <table class="table table-bordered table-condensed table-hover table-striped">
                <thead>
                    <tr>
                        @if (in_array($human_resource_request->reqtype, ['PER', 'AUS']))
                            @if ($human_resource_request->detail->pertype == 'one_day')
                                <th>Fecha</th>
                                <th>Hora Desde</th>
                                <th>Hora Hasta</th>
                            @endif

                            @if ($human_resource_request->detail->pertype == 'multiple_days')
                                <th>Fecha Desde</th>
                                <th>Fecha Hasta</th>
                            @endif
                        @endif

                        @if (in_array($human_resource_request->reqtype, ['VAC']))
                            <th>Fecha Inicio</th>
                            <th>Fecha Reintegro</th>
                        @endif
                        <th>Observación</th>
                        <th>Modificado el</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($human_resource_request->detail->history as $history)
                        <tr>
                            @if (in_array($human_resource_request->reqtype, ['PER', 'AUS']))
                                @if ($human_resource_request->detail->pertype == 'one_day')
                                    <td>{{ date_create($history->perdatfror)->format('d/m/Y') }}</td>
                                    <td>{{ date_create($history->pertimfror)->format('h:i:s a') }}</td>
                                    <td>{{ date_create($history->pertimtor)->format('h:i:s a') }}</td>
                                @endif

                                @if ($human_resource_request->detail->pertype == 'multiple_days')
                                    <td>{{ date_create($history->perdatfror)->format('d/m/Y') }}</td>
                                    <td>{{ date_create($history->perdattor)->format('d/m/Y') }}</td>
                                @endif
                            @endif

                            @if (in_array($human_resource_request->reqtype, ['VAC']))
                                <td>{{ date_create($history->vacdatfror)->format('d/m/Y') }}</td>
                                <td>{{ date_create($history->vacdattor)->format('d/m/Y') }}</td>
                            @endif
                            <td>{{ $history->observar }}</td>
                            <td>{{ $history->created_at->format('d/m/Y h:i:s a') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>