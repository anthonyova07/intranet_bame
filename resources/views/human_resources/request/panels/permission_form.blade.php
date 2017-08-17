<div class="row text-center">
    <div class="col-xs-6">
        <div class="radio{{ $errors->first('permission_type') ? ' has-error':'' }}">
            <label style="font-size: 16px;font-weight: bold;">
                <input type="radio"{{ in_array($type, ['AUS']) ? ' checked' : '' }} name="permission_type" {{ old('permission_type') == 'one_day' ? 'checked' : '' }} value="one_day"> Por un día o menos
            </label>
            <span class="help-block">{{ $errors->first('permission_type') }}</span>
        </div>
    </div>
    @if (!in_array($type, ['AUS']))
        <div class="col-xs-6">
            <div class="radio{{ $errors->first('permission_type') ? ' has-error':'' }}">
                <label style="font-size: 16px;font-weight: bold;">
                    <input type="radio" name="permission_type" {{ old('permission_type') == 'multiple_days' ? 'checked' : '' }} value="multiple_days"> Por varios días
                </label>
                <span class="help-block">{{ $errors->first('permission_type') }}</span>
            </div>
        </div>
    @endif
</div>
<div class="row">
    <div class="col-xs-6">
        <div class="well well-sm" id="one_day"{!! old('permission_type') == 'multiple_days' ? ' style="display: none;"' : '' !!}>
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
                        <input type="time" class="form-control input-sm" name="permission_time_from" value="{{ old('permission_time_from') ? old('permission_time_from') : '08:30' }}">
                        <span class="help-block">{{ $errors->first('permission_time_from') }}</span>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="form-group{{ $errors->first('permission_time_to') ? ' has-error':'' }}">
                        <label class="control-label">Hora Hasta</label>
                        <input type="time" class="form-control input-sm" name="permission_time_to" value="{{ old('permission_time_to') ? old('permission_time_to') : '17:30' }}">
                        <span class="help-block">{{ $errors->first('permission_time_to') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (!in_array($type, ['AUS']))
        <div class="col-xs-6">
            <div class="well well-sm" id="multiple_days"{!! old('permission_type') == 'one_day' ? ' style="display: none;"' : '' !!}>
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
    @endif
</div>
<div class="row">
    <div class="col-xs-12" style="height: 15px;">
        <div class="form-group{{ $errors->first('per') ? ' has-error':'' }}">
            <label class="control-label" style="font-size: 16px;">
                Razón de la Ausencia
                @if ($errors->first('per'))
                    <small>({{ $errors->first('per') }})</small>
                @endif
            </label>
        </div>
    </div>
    @if (in_array($type, ['PER']))
        @foreach ($params->where('type', 'PER') as $param)
            <div class="col-xs-2" style="height: 35px;">
                <div class="radio">
                    <label style="font-weight: bold;">
                        <input type="radio" name="per" {{ old('per') == $param->id ? 'checked' : '' }} value="{{ $param->id }}"> {{ $param->name }}
                    </label>
                </div>
            </div>
        @endforeach
    @endif
    <div class="col-xs-12">
        <div class="form-group{{ $errors->first('per_reason') ? ' has-error':'' }}">
            <label class="control-label">
                @if (in_array($type, ['PER']))
                    <input type="radio" name="per" {{ old('per') == 'otro' ? 'checked' : '' }} value="otro"> Otro
                @else
                    <input type="radio" name="per" checked value="otro"> Otro
                @endif
            </label>
            <textarea class="form-control input-sm" placeholder="Especifique la razón la ausencia..." name="per_reason">{{ old('per_reason') }}</textarea>
            <span class="help-block">{{ $errors->first('per_reason') }}</span>
        </div>
    </div>
</div>
