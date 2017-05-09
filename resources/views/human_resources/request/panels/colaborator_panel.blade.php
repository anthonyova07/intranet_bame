@if (isset($human_resource_request))
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Datos del Empleado</h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('coluser') ? ' has-error':'' }}">
                            <label class="control-label">Usuario</label>
                            <p class="form-control-static">{{ $human_resource_request->coluser }}</p>
                            <span class="help-block">{{ $errors->first('coluser') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('colcode') ? ' has-error':'' }}">
                            <label class="control-label">Código</label>
                            <p class="form-control-static">{{ $human_resource_request->colcode }}</p>
                            <span class="help-block">{{ $errors->first('colcode') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('colname') ? ' has-error':'' }}">
                            <label class="control-label">Nombre</label>
                            <p class="form-control-static">{{ $human_resource_request->colname }}</p>
                            <span class="help-block">{{ $errors->first('colname') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group{{ $errors->first('colposi') ? ' has-error':'' }}">
                            <label class="control-label">Posición</label>
                            <p class="form-control-static">{{ $human_resource_request->colposi }}</p>
                            <span class="help-block">{{ $errors->first('colposi') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group{{ $errors->first('coldepart') ? ' has-error':'' }}">
                            <label class="control-label">Departamento</label>
                            <p class="form-control-static">{{ $human_resource_request->coldepart }}</p>
                            <span class="help-block">{{ $errors->first('coldepart') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Datos del Empleado</h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('coluser') ? ' has-error':'' }}">
                            <label class="control-label">Usuario</label>
                            <p class="form-control-static">{{ session()->get('user') }}</p>
                            <span class="help-block">{{ $errors->first('coluser') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('colcode') ? ' has-error':'' }}">
                            <label class="control-label">Código</label>
                            <p class="form-control-static">{{ session()->get('user_info')->getPostalCode() }}</p>
                            <span class="help-block">{{ $errors->first('colcode') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('colname') ? ' has-error':'' }}">
                            <label class="control-label">Nombre</label>
                            <p class="form-control-static">{{ session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName() }}</p>
                            <span class="help-block">{{ $errors->first('colname') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group{{ $errors->first('colposi') ? ' has-error':'' }}">
                            <label class="control-label">Posición</label>
                            <p class="form-control-static">{{ session()->get('user_info')->getTitle() }}</p>
                            <span class="help-block">{{ $errors->first('colposi') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group{{ $errors->first('coldepart') ? ' has-error':'' }}">
                            <label class="control-label">Departamento</label>
                            <p class="form-control-static">{{ session()->get('user_info')->getDepartment() }}</p>
                            <span class="help-block">{{ $errors->first('coldepart') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
