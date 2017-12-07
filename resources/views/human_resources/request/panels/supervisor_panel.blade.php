@if (in_array($type, ['PER', 'VAC']))
    <div class="col-xs-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Datos del Supervisor
                    @if (isset($human_resource_request))
                        @if ($human_resource_request->approvesup == 'p')
                            (Pendiente)
                        @else
                            @if ($human_resource_request->approvesup == 'a')
                                (Aprobada)
                            @else
                                (Rechazada)
                            @endif
                        @endif
                    @endif
                </h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('colsupuser') ? ' has-error':'' }}">
                            <label class="control-label">Usuario</label>
                            @if (isset($human_resource_request))
                                <p class="form-control-static">{{ $human_resource_request->colsupuser }}</p>
                            @else
                                <p class="form-control-static">{{ isset($human_resource_request) ? $human_resource_request->colsupname : session('employee')->supervisor_emp->useremp }}</p>
                                <span class="help-block">{{ $errors->first('colsupuser') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-8">
                        <div class="form-group">
                            <label class="control-label">Nombre</label>
                            <p class="form-control-static">{{ isset($human_resource_request) ? $human_resource_request->colsupname : session('employee')->supervisor_emp->full_name() }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Posición</label>
                            <p class="form-control-static">{{ isset($human_resource_request) ? $human_resource_request->colsupposi : session('employee')->supervisor_emp->position->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if (in_array($type, ['AUS']))
    <div class="col-xs-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Datos del Supervisor
                </h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label class="control-label">Usuario</label>
                            <p class="form-control-static">{{ session('employee')->useremp }}</p>
                        </div>
                    </div>
                    <div class="col-xs-8">
                        <div class="form-group">
                            <label class="control-label">Nombre</label>
                            <p class="form-control-static">{{ session('employee')->full_name() }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Posición</label>
                            <p class="form-control-static">{{ session('employee')->position->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
