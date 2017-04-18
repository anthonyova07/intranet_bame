<div class="col-xs-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Datos del Empleado</h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4">
                    <div class="form-group{{ $errors->first('coluser') ? ' has-error':'' }}">
                        <label class="control-label">Usuario</label>
                        <input type="text" class="form-control input-sm" name="coluser" readonly value="{{ session()->get('user') }}">
                        <span class="help-block">{{ $errors->first('coluser') }}</span>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="form-group{{ $errors->first('colcode') ? ' has-error':'' }}">
                        <label class="control-label">Código</label>
                        <input type="text" class="form-control input-sm" name="colcode" readonly value="{{ session()->get('user_info')->getPostalCode() }}">
                        <span class="help-block">{{ $errors->first('colcode') }}</span>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="form-group{{ $errors->first('colname') ? ' has-error':'' }}">
                        <label class="control-label">Nombre</label>
                        <input type="text" class="form-control input-sm" name="colname" readonly value="{{ session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName() }}">
                        <span class="help-block">{{ $errors->first('colname') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('colposi') ? ' has-error':'' }}">
                        <label class="control-label">Posición</label>
                        <input type="text" class="form-control input-sm" name="colposi" readonly value="{{ session()->get('user_info')->getTitle() }}">
                        <span class="help-block">{{ $errors->first('colposi') }}</span>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('coldepart') ? ' has-error':'' }}">
                        <label class="control-label">Departamento</label>
                        <input type="text" class="form-control input-sm" name="coldepart" readonly value="{{ session()->get('user_info')->getDepartment() }}">
                        <span class="help-block">{{ $errors->first('coldepart') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
