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
    ])

    @include('human_resources.request.panels.rhuser_panel', [
        'human_resource_request' => $human_resource_request,
    ])
</div>

<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Detalle de la Solicitud ({{ rh_req_types($human_resource_request->reqtype) }})</h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label class="control-label">Tipo de Paquetes</label>
                            <p class="form-control-static">{{ $human_resource_request->detail->carpackage }}</p>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label class="control-label">Periodo</label>
                            <p class="form-control-static">{{ $human_resource_request->detail->caredoperi }}</p>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label class="control-label">Modo de Retiro</label>
                            <p class="form-control-static">{{ $human_resource_request->detail->carmodreti }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label">Dirigido a</label>
                            <p class="form-control-static">{{ $human_resource_request->detail->caraddreto }}</p>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label">Comentarios</label>
                            <p class="form-control-static">{{ $human_resource_request->detail->carcomment }}</p>
                        </div>
                    </div>
                </div>
                @if ($human_resource_request->approverh)
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <a class="btn btn-success btn-xs" href="{{ route('human_resources.request.changestatus', ['request_id' => $human_resource_request->id, 'status' => 'Generada y Enviada']) }}"> Generada y Enviada</a>
                            <a class="btn btn-success btn-xs" href="{{ route('human_resources.request.changestatus', ['request_id' => $human_resource_request->id, 'status' => 'Generada y Retirar en RRHH']) }}"> Generada y Retirar en RRHH</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    //
</script>
