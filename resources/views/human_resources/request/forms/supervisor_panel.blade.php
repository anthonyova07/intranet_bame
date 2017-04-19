<div class="col-xs-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Datos del Supervisor</h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4">
                    <div class="form-group{{ $errors->first('colsupuser') ? ' has-error':'' }}">
                        <label class="control-label">Usuario</label>
                        <input type="text" class="form-control input-sm" name="colsupuser" value="">
                        <span class="help-block">{{ $errors->first('colsupuser') }}</span>
                    </div>
                </div>
                <div class="col-xs-8">
                    <div class="form-group{{ $errors->first('colsupname') ? ' has-error':'' }}">
                        <label class="control-label">Nombre</label>
                        <input type="text" class="form-control input-sm" name="colsupname" readonly value="">
                        <span class="help-block">{{ $errors->first('colsupname') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group{{ $errors->first('colsupposi') ? ' has-error':'' }}">
                        <label class="control-label">Posición</label>
                        <input type="text" class="form-control input-sm" name="colsupposi" readonly value="">
                        <span class="help-block">{{ $errors->first('colsupposi') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
