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
                <h3 class="panel-title">Detalle de la Solicitud ( {{ rh_req_types($human_resource_request->reqtype) }} )</h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-2">
                        <div class="form-group">
                            <label class="control-label">Fecha de Ingreso</label>
                            <input type="date" disabled class="form-control input-sm" name="vac_date_admission" value="{{ $human_resource_request->detail->vacdatadmi }}">
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="form-group">
                            <label class="control-label">Días a Tomar</label>
                            <input type="number" disabled class="form-control input-sm" name="vac_total_days" value="{{ $human_resource_request->detail->vactotdays }}">
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="form-group">
                            <label class="control-label">Días Adicionales</label>
                            <input type="number" disabled class="form-control input-sm" name="vac_additional_days" value="{{ $human_resource_request->detail->vacadddays }}">
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="form-group">
                            <label class="control-label">Días Pendientes por Tomar</label>
                            <input type="number" disabled class="form-control input-sm" name="vac_total_pending_days" value="{{ $human_resource_request->detail->vacoutdays }}">
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="form-group">
                            <label class="control-label">Fecha de Inicio</label>
                            <input type="date" disabled class="form-control input-sm" name="vac_date_from" value="{{ $human_resource_request->detail->vacdatfrom }}">
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="form-group">
                            <label class="control-label">Fecha de Reintegro</label>
                            <input type="date" disabled class="form-control input-sm" readonly name="vac_date_to" value="{{ $human_resource_request->detail->vacdatto }}">
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="checkbox" style="margin-top: 22px;">
                            <label>
                                <input type="checkbox" disabled name="vac_credited_bonds" {{ $human_resource_request->detail->vacaccbonu ? 'checked' : '' }} value="acreditar_bono"> Acreditar Bono Vacacional
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        @include('human_resources.request.panels.vac_show_rrhh', [
                            'human_resource_request' => $human_resource_request,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
