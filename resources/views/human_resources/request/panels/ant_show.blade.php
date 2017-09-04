<div class="row">
    @include('human_resources.request.panels.colaborator_panel', [
        'human_resource_request' => $human_resource_request,
        'type' => $human_resource_request->reqtype,
    ])

    @include('human_resources.request.panels.supervisor_panel', [
        'human_resource_request' => $human_resource_request,
        'type' => $human_resource_request->reqtype,
    ])
</div>

<div class="row">
    @include('human_resources.request.panels.info_panel', [
        'human_resource_request' => $human_resource_request,
        'statuses' => $statuses,
    ])

    @include('human_resources.request.panels.rhuser_panel', [
        'human_resource_request' => $human_resource_request,
    ])
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Detalle de la Solicitud ({{ rh_req_types($human_resource_request->reqtype) }})</h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label class="control-label"># Cuenta (Ahorro)</label>
                            <input type="text" disabled class="form-control input-sm" name="ant_account_number" value="{{ $human_resource_request->detail->savaccount }}">
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label class="control-label">Monto</label>
                            <input type="text" disabled class="form-control input-sm text-right" name="ant_amount" value="{{ number_format($human_resource_request->detail->advamount, 2) }}">
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label class="control-label">Cuotas (MAX: 12)</label>
                            <input type="number" disabled class="form-control input-sm" name="ant_dues" value="{{ $human_resource_request->detail->advdues }}">
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label class="control-label">Monto de Cuotas</label>
                            <input type="text" disabled class="form-control text-right input-sm" name="ant_due_amount" value="{{ number_format($human_resource_request->detail->advdueamou, 2) }}">
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Monto de Cuotas</label>
                            <textarea class="form-control input-sm" disabled placeholder="Observaciones" name="ant_observa">{{ $human_resource_request->detail->observa }}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        @include('human_resources.request.panels.ant_show_rrhh', [
                            'human_resource_request' => $human_resource_request,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
