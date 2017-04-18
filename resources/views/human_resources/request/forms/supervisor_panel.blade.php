<div class="col-xs-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Datos del Supervisor</h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4">
                    <div class="form-group{{ $errors->first('coluser') ? ' has-error':'' }}">
                        <label class="control-label">Usuario</label>
                        <input type="text" class="form-control input-sm" name="coluser" value="">
                        <span class="help-block">{{ $errors->first('coluser') }}</span>
                    </div>
                </div>
                <div class="col-xs-8">
                    <div class="form-group{{ $errors->first('colname') ? ' has-error':'' }}">
                        <label class="control-label">Nombre</label>
                        <input type="text" class="form-control input-sm" name="colname" readonly value="">
                        <span class="help-block">{{ $errors->first('colname') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group{{ $errors->first('colposi') ? ' has-error':'' }}">
                        <label class="control-label">Posición</label>
                        <input type="text" class="form-control input-sm" name="colposi" readonly value="">
                        <span class="help-block">{{ $errors->first('colposi') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
