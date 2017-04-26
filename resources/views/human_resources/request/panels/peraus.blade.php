<form method="post" action="{{ route('human_resources.request.store', ['type' => $type]) }}" id="form">

    <div class="row">
        @include('human_resources.request.panels.colaborator_panel')

        @include('human_resources.request.panels.supervisor_panel')
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Datos de la Solicitud ( {{ $type_desc }} )</h3>
                </div>

                <div class="panel-body">
                    <div class="row text-center">
                        <div class="col-xs-6">
                            <div class="radio{{ $errors->first('permission_type') ? ' has-error':'' }}">
                                <label style="font-size: 16px;font-weight: bold;">
                                    <input type="radio" name="permission_type" {{ old('permission_type') == 'one_day' ? 'checked' : '' }} value="one_day"> Por un día o menos
                                </label>
                                <span class="help-block">{{ $errors->first('permission_type') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="radio{{ $errors->first('permission_type') ? ' has-error':'' }}">
                                <label style="font-size: 16px;font-weight: bold;">
                                    <input type="radio" name="permission_type" {{ old('permission_type') == 'multiple_days' ? 'checked' : '' }} value="multiple_days"> Por varios días
                                </label>
                                <span class="help-block">{{ $errors->first('permission_type') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="well well-sm">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="form-group{{ $errors->first('permission_date') ? ' has-error':'' }}">
                                            <label class="control-label">Fecha</label>
                                            <input type="date" class="form-control input-sm" name="permission_date" value="{{ old('permission_date') }}">
                                            <span class="help-block">{{ $errors->first('permission_date') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-group{{ $errors->first('permission_time_from') ? ' has-error':'' }}">
                                            <label class="control-label">Hora Desde</label>
                                            <input type="time" class="form-control input-sm" name="permission_time_from" value="{{ old('permission_time_from') }}">
                                            <span class="help-block">{{ $errors->first('permission_time_from') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-group{{ $errors->first('permission_time_to') ? ' has-error':'' }}">
                                            <label class="control-label">Hora Hasta</label>
                                            <input type="time" class="form-control input-sm" name="permission_time_to" value="{{ old('permission_time_to') }}">
                                            <span class="help-block">{{ $errors->first('permission_time_to') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="well well-sm">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group{{ $errors->first('permission_date_from') ? ' has-error':'' }}">
                                            <label class="control-label">Fecha Desde</label>
                                            <input type="date" class="form-control input-sm" name="permission_date_from" value="{{ old('permission_date_from') }}">
                                            <span class="help-block">{{ $errors->first('permission_date_from') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group{{ $errors->first('permission_date_to') ? ' has-error':'' }}">
                                            <label class="control-label">Fecha Hasta</label>
                                            <input type="date" class="form-control input-sm" name="permission_date_to" value="{{ old('permission_date_to') }}">
                                            <span class="help-block">{{ $errors->first('permission_date_to') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12" style="height: 15px;">
                            <div class="form-group{{ $errors->first('peraus') ? ' has-error':'' }}">
                                <label class="control-label" style="font-size: 16px;">
                                    Razón de la Ausencia
                                    @if ($errors->first('peraus'))
                                        <small>({{ $errors->first('peraus') }})</small>
                                    @endif
                                </label>
                            </div>
                        </div>
                        @foreach ($params->where('type', 'PERAUS') as $param)
                            <div class="col-xs-2" style="height: 35px;">
                                <div class="radio">
                                    <label style="font-weight: bold;">
                                        <input type="radio" name="peraus" {{ old('peraus') == $param->id ? 'checked' : '' }} value="{{ $param->id }}"> {{ $param->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-xs-12">
                            <div class="form-group{{ $errors->first('peraus_reason') ? ' has-error':'' }}">
                                <label class="control-label">
                                    <input type="radio" name="peraus" {{ old('peraus') == 'otro' ? 'checked' : '' }} value="otro"> Otro
                                </label>
                                <textarea class="form-control input-sm" placeholder="Especifique la razón la ausencia..." name="peraus_reason">{{ old('peraus_reason') }}</textarea>
                                <span class="help-block">{{ $errors->first('peraus_reason') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            {{ csrf_field() }}
                            <a class="btn btn-info btn-xs" href="{{ route('human_resources.request.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
