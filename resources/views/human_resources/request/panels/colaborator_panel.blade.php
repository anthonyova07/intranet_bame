@if (in_array($type, ['PER', 'VAC', 'ANT']))
    <div class="col-xs-8{{ in_array($type, ['ANT']) ? ' col-xs-offset-2' : '' }}">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Datos del Empleado</h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('coluser') ? ' has-error':'' }}">
                            <label class="control-label">Usuario</label>
                            <p class="form-control-static">
                                @if (isset($human_resource_request))
                                    {{ $human_resource_request->coluser }}
                                @else
                                    {{ session('employee')->useremp }}
                                @endif
                            </p>
                            <span class="help-block">{{ $errors->first('coluser') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('colcode') ? ' has-error':'' }}">
                            <label class="control-label">Código</label>
                            <p class="form-control-static">
                                @if (isset($human_resource_request))
                                    {{ $human_resource_request->colcode }}
                                @else
                                    {{ session('employee')->recordcard }}
                                @endif
                            </p>
                            <span class="help-block">{{ $errors->first('colcode') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('colname') ? ' has-error':'' }}">
                            <label class="control-label">Nombre</label>
                            <p class="form-control-static">
                                @if (isset($human_resource_request))
                                    {{ $human_resource_request->colname }}
                                @else
                                    {{ session('employee')->name }}
                                @endif
                            </p>
                            <span class="help-block">{{ $errors->first('colname') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('colposi') ? ' has-error':'' }}">
                            <label class="control-label">Posición</label>
                            <p class="form-control-static">
                                @if (isset($human_resource_request))
                                    {{ $human_resource_request->colposi }}
                                @else
                                    {{ session('employee')->position->name }}
                                @endif
                            </p>
                            <span class="help-block">{{ $errors->first('colposi') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('coldepart') ? ' has-error':'' }}">
                            <label class="control-label">Departamento</label>
                            <p class="form-control-static">
                                @if (isset($human_resource_request))
                                    {{ $human_resource_request->coldepart }}
                                @else
                                    {{ session('employee')->department->name }}
                                @endif
                            </p>
                            <span class="help-block">{{ $errors->first('coldepart') }}</span>
                        </div>
                    </div>
                    @if (in_array($type, ['ANT']))
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('identification') ? ' has-error':'' }}">
                                <label class="control-label">Identificación</label>
                                <p class="form-control-static">
                                    @if (isset($human_resource_request))
                                        {{ $human_resource_request->detail->identifica }}
                                    @else
                                        {{ session('employee')->identifica }}
                                    @endif
                                </p>
                                <span class="help-block">{{ $errors->first('identification') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

@if (in_array($type, ['AUS']))
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Datos del Empleado</h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group{{ $errors->first('subordinate') ? ' has-error':'' }}">
                            <label class="control-label">Seleccionar Empleado</label>
                            <select name="subordinate" class="form-control input-sm">
                                @foreach (session('employee')->subordinates as $subordinate)
                                    <option value="{{ $subordinate->useremp }}">{{ $subordinate->name }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('subordinate') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
