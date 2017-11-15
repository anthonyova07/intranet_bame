@extends('layouts.master')

@section('title', 'Riesgo - Eventos')

@section('page_title', 'Creación de Evento - Riesgo Operacional')

{{-- @if (can_not_do('process_request'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <form method="post" action="{{ route('risk.event.store') }}" id="form">

        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos del Evento</h3>
                    </div>

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('business_line') ? ' has-error':'' }}">
                                    <label class="control-label">Linea de Negocio</label>
                                    <select class="form-control input-sm" name="business_line">
                                        <option value="">Selecciona uno</option>
                                        @foreach ($params->where('type', 'LN') as $param)
                                            <option value="{{ $param->id }}" {{ old('business_line') == $param->id ? 'selected':'' }}>{{ $param->note }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('business_line') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('event_type') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo de Evento</label>
                                    <select class="form-control input-sm" name="event_type">
                                        <option value="">Selecciona uno</option>
                                        @foreach ($params->where('type', 'TE') as $param)
                                            <option value="{{ $param->id }}" {{ old('event_type') == $param->id ? 'selected':'' }}>{{ $param->note }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('event_type') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('currency_type') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo de Divisa</label>
                                    <select class="form-control input-sm" name="currency_type">
                                        <option value="">Selecciona uno</option>
                                        @foreach ($params->where('type', 'TD') as $param)
                                            <option value="{{ $param->id }}" {{ old('currency_type') == $param->id ? 'selected':'' }}>{{ $param->note }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('currency_type') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('branch_office') ? ' has-error':'' }}">
                                    <label class="control-label">Sucursal</label>
                                    <select class="form-control input-sm" name="branch_office">
                                        <option value="">Selecciona uno</option>
                                        @foreach ($params->where('type', 'SU') as $param)
                                            <option value="{{ $param->id }}" {{ old('branch_office') == $param->id ? 'selected':'' }}>{{ $param->note }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('branch_office') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('area_department') ? ' has-error':'' }}">
                                    <label class="control-label">Área o Departamento</label>
                                    <select class="form-control input-sm" name="area_department">
                                        <option value="">Selecciona uno</option>
                                        @foreach ($params->where('type', 'AD') as $param)
                                            <option value="{{ $param->id }}" {{ old('area_department') == $param->id ? 'selected':'' }}>{{ $param->note }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('area_department') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('distribution_channel') ? ' has-error':'' }}">
                                    <label class="control-label">Canal de Distribución</label>
                                    <select class="form-control input-sm" name="distribution_channel">
                                        <option value="">Selecciona uno</option>
                                        @foreach ($params->where('type', 'CD') as $param)
                                            <option value="{{ $param->id }}" {{ old('distribution_channel') == $param->id ? 'selected':'' }}>{{ $param->note }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('distribution_channel') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('process') ? ' has-error':'' }}">
                                    <label class="control-label">Proceso</label>
                                    <select class="form-control input-sm" name="process">
                                        <option value="">Selecciona uno</option>
                                        @foreach ($params->where('type', 'PR') as $param)
                                            <option value="{{ $param->id }}" {{ old('process') == $param->id ? 'selected':'' }}>{{ $param->note }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('process') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('subprocess') ? ' has-error':'' }}">
                                    <label class="control-label">SubProceso</label>
                                    <select class="form-control input-sm" name="subprocess">
                                        <option value="">Selecciona uno</option>
                                        @foreach ($params->where('type', 'SP') as $param)
                                            <option value="{{ $param->id }}" {{ old('subprocess') == $param->id ? 'selected':'' }}>{{ $param->note }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('subprocess') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('description') ? ' has-error':'' }}">
                                    <label class="control-label">Descripción</label>
                                    <textarea class="form-control input-sm" rows="5" name="description">{{ old('description') }}</textarea>
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('consequence') ? ' has-error':'' }}">
                                    <label class="control-label">Consecuencia</label>
                                    <textarea class="form-control input-sm" rows="5" name="consequence">{{ old('consequence') }}</textarea>
                                    <span class="help-block">{{ $errors->first('consequence') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('associated_control') ? ' has-error':'' }}">
                                    <label class="control-label">Control Asociado</label>
                                    <textarea class="form-control input-sm" rows="5" name="associated_control">{{ old('associated_control') }}</textarea>
                                    <span class="help-block">{{ $errors->first('associated_control') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4">
                                {{ csrf_field() }}
                                <a class="btn btn-info btn-xs" href="{{ route('risk.event.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
