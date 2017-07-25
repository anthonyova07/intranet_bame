<form method="post" class="form-inline" action="{{ route('human_resources.employee.{type}.params.loadparams', ['type' => $type]) }}" id="form" enctype="multipart/form-data" novalidate>
    <div class="form-group{{ $errors->first('date_file') ? ' has-error':'' }}">
        <input type="file" name="params" id="params" style="width: 140px;">
        <span class="help-block">{{ $errors->first('date_file') }}</span>
    </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Cargando...">Cargar</button>
</form>
