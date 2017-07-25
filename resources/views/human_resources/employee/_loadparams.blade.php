<form method="post" class="form-inline" action="{{ route('human_resources.employee.{type}.params.loadparams', ['type' => $type]) }}" id="form" enctype="multipart/form-data" novalidate>
    <div class="form-group{{ $errors->first('date_file') ? ' has-error':'' }}">
        <label class="control-label">Cargar Masiva</label>
        <input type="file" name="params">
        <span class="help-block">{{ $errors->first('date_file') }}</span>
    </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Cargando...">Cargar</button>
</form>
