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
                    <div class="col-xs-4">
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
                    <div class="col-xs-4">
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
                    @if (in_array($type, ['ANT']))
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('identification') ? ' has-error':'' }}">
                                <label class="control-label">Identificación</label>
                                <p class="form-control-static">
                                    @if (isset($human_resource_request))
                                        {{ $human_resource_request->detail->identifica }}
                                    @else
                                        <input type="text" class="form-control input-sm" name="identification" value="{{ old('identification') }}">
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
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('coluser') ? ' has-error':'' }}">
                            <label class="control-label">Usuario</label>
                            @if (isset($human_resource_request))
                                <p class="form-control-static">{{ $human_resource_request->coluser }}</p>
                            @else
                                <input type="text" class="form-control input-sm" name="coluser" value="{{ old('coluser') }}">
                            @endif
                            <span class="help-block">{{ $errors->first('coluser') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('colcode') ? ' has-error':'' }}">
                            <label class="control-label">Código</label>
                            @if (isset($human_resource_request))
                                <p class="form-control-static">{{ $human_resource_request->colcode }}</p>
                            @else
                                <input type="text" class="form-control input-sm" name="colcode" value="{{ old('colcode') }}">
                            @endif
                            <span class="help-block">{{ $errors->first('colcode') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('colname') ? ' has-error':'' }}">
                            <label class="control-label">Nombre</label>
                            @if (isset($human_resource_request))
                                <p class="form-control-static">{{ $human_resource_request->colname }}</p>
                            @else
                                <input type="text" class="form-control input-sm" name="colname" value="{{ old('colname') }}">
                            @endif
                            <span class="help-block">{{ $errors->first('colname') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('colposi') ? ' has-error':'' }}">
                            <label class="control-label">Posición</label>
                            @if (isset($human_resource_request))
                                <p class="form-control-static">{{ $human_resource_request->colposi }}</p>
                            @else
                                <input type="text" class="form-control input-sm" name="colposi" value="{{ old('colposi') }}">
                            @endif
                            <span class="help-block">{{ $errors->first('colposi') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group{{ $errors->first('coldepart') ? ' has-error':'' }}">
                            <label class="control-label">Departamento</label>
                            @if (isset($human_resource_request))
                                <p class="form-control-static">{{ $human_resource_request->coldepart }}</p>
                            @else
                                <input type="text" class="form-control input-sm" name="coldepart" value="{{ old('coldepart') }}">
                            @endif
                            <span class="help-block">{{ $errors->first('coldepart') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
