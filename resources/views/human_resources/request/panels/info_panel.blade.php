<div class="col-xs-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                Datos de la Solicitud
            </h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4">
                    <div class="form-group">
                        <label class="control-label"># de Solicitud</label>
                        <p class="form-control-static">{{ $human_resource_request->reqnumber }}</p>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="form-group">
                        <label class="control-label">Tipo de Solicitud</label>
                        <p class="form-control-static">{{ rh_req_types($human_resource_request->reqtype) }}</p>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="form-group">
                        <label class="control-label">Estado</label>
                        <p class="form-control-static">{{ $human_resource_request->reqstatus }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
