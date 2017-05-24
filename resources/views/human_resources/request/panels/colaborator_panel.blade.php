@if (in_array($type, ['PER', 'VAC']))
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
                            <p class="form-control-static">
                                @if (isset($human_resource_request))
                                    {{ $human_resource_request->coluser }}
                                @else
                                    {{ session()->get('user') }}
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
                                    {{ session()->get('user_info')->getPostalCode() }}
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
                                    {{ session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName() }}
                                @endif
                            </p>
                            <span class="help-block">{{ $errors->first('colname') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group{{ $errors->first('colposi') ? ' has-error':'' }}">
                            <label class="control-label">Posición</label>
                            <p class="form-control-static">
                                @if (isset($human_resource_request))
                                    {{ $human_resource_request->colposi }}
                                @else
                                    {{ session()->get('user_info')->getTitle() }}
                                @endif
                            </p>
                            <span class="help-block">{{ $errors->first('colposi') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group{{ $errors->first('coldepart') ? ' has-error':'' }}">
                            <label class="control-label">Departamento</label>
                            <p class="form-control-static">
                                @if (isset($human_resource_request))
                                    {{ $human_resource_request->coldepart }}
                                @else
                                    {{ session()->get('user_info')->getDepartment() }}
                                @endif
                            </p>
                            <span class="help-block">{{ $errors->first('coldepart') }}</span>
                        </div>
                    </div>
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
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('coluser') ? ' has-error':'' }}">
                            <label class="control-label">Usuario</label>
                            <p class="form-control-static">
                                @if (isset($human_resource_request))
                                    {{ $human_resource_request->coluser }}
                                @else
                                    <input type="text" class="form-control input-sm" name="coluser" value="{{ old('coluser') }}">
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
                                    <input type="text" class="form-control input-sm" name="colcode" value="{{ old('colcode') }}">
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
                                    <input type="text" class="form-control input-sm" name="colname" value="{{ old('colname') }}">
                                @endif
                            </p>
                            <span class="help-block">{{ $errors->first('colname') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group{{ $errors->first('colposi') ? ' has-error':'' }}">
                            <label class="control-label">Posición</label>
                            <p class="form-control-static">
                                @if (isset($human_resource_request))
                                    {{ $human_resource_request->colposi }}
                                @else
                                    <input type="text" class="form-control input-sm" name="colposi" value="{{ old('colposi') }}">
                                @endif
                            </p>
                            <span class="help-block">{{ $errors->first('colposi') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group{{ $errors->first('coldepart') ? ' has-error':'' }}">
                            <label class="control-label">Departamento</label>
                            <p class="form-control-static">
                                @if (isset($human_resource_request))
                                    {{ $human_resource_request->coldepart }}
                                @else
                                    <input type="text" class="form-control input-sm" name="coldepart" value="{{ old('coldepart') }}">
                                @endif
                            </p>
                            <span class="help-block">{{ $errors->first('coldepart') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
