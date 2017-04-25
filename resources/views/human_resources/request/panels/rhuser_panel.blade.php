<div class="col-xs-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                Recursos Humanos
                @if (isset($human_resource_request))
                    (
                    @if (!$human_resource_request->rhuser)
                        Pendiente
                    @else
                        @if ($human_resource_request->approverh)
                            Aprobada
                        @else
                            Rechazada
                        @endif
                    @endif
                    )
                @endif
            </h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4">
                    <div class="form-group">
                        <label class="control-label">Usuario</label>
                        <p class="form-control-static">{{ $human_resource_request->thuser }}</p>
                    </div>
                </div>
                <div class="col-xs-8">
                    <div class="form-group">
                        <label class="control-label">Nombre</label>
                        <p class="form-control-static">{{ isset($human_resource_request) ? $human_resource_request->rhname : 'Pendiente' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
