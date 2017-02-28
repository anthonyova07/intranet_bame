@extends('layouts.master')

@section('title', 'Clientes - Reclamaciones')

@section('page_title', 'Nueva Solicitud de Proceso')

@if (can_not_do('process_request'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <form method="post" action="{{ route('process.request.store') }}" id="form">

        <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos de la Solicitud</h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('request_type') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo de Solicitud</label>
                                    <select class="form-control input-sm" name="request_type">
                                        <option value="">Selecciona un tipo de solicitud</option>
                                        @foreach ($request_types as $request_type)
                                            <option value="{{ $request_type->id }}" {{ old('request_type') == $request_type->id ? 'selected':'' }}>{{ $request_type->note }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('request_type') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('process') ? ' has-error':'' }}">
                                    <label class="control-label">Proceso Impactado</label>
                                    <select class="form-control input-sm" name="process">
                                        <option value="">Selecciona un proceso</option>
                                        @foreach ($processes->where('id_parent', '') as $process)
                                            <option value="{{ $process->id }}" {{ old('process') == $process->id ? 'selected':'' }}>{{ $process->name . ' (' . $process->version . ')' }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('process') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('subprocess') ? ' has-error':'' }}">
                                    <label class="control-label">Subproceso Impactado</label>
                                    <select style="display: none;" class="form-control input-sm" name="subprocess">
                                        @foreach ($processes as $subprocess)
                                            @if ($subprocess->id_parent != '')
                                                <option
                                                    parent="{{ $subprocess->id_parent }}"
                                                    value="{{ $subprocess->id }}"
                                                    {{ old('subprocess') == $subprocess->id ? 'selected':'' }}>
                                                    {{ $subprocess->name . ' (' . $subprocess->version . ')' }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('subprocess') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('description') ? ' has-error':'' }}">
                                    <label class="control-label">Descripción</label>
                                    <textarea class="form-control input-sm" rows="5" name="description">{{ old('description') }}</textarea>
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('cause_analysis') ? ' has-error':'' }}">
                                    <label class="control-label">Análisis de Causa</label>
                                    <textarea class="form-control input-sm" rows="5" name="cause_analysis">{{ old('cause_analysis') }}</textarea>
                                    <span class="help-block">{{ $errors->first('cause_analysis') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('people_involved') ? ' has-error':'' }}">
                                    <label class="control-label">Personas que Intervinieron en el Análisis</label>
                                    <textarea class="form-control input-sm" rows="5" name="people_involved">{{ old('people_involved') }}</textarea>
                                    <span class="help-block">{{ $errors->first('people_involved') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('deliverable') ? ' has-error':'' }}">
                                    <label class="control-label">Entregables</label>
                                    <textarea class="form-control input-sm" rows="5" name="deliverable">{{ old('deliverable') }}</textarea>
                                    <span class="help-block">{{ $errors->first('deliverable') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Observaciones</label>
                                    <textarea class="form-control input-sm" rows="5" name="observations">{{ old('observations') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                {{ csrf_field() }}
                                <a class="btn btn-info btn-xs" href="{{ route('process.request.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
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

        $('select[name=process]').change(function (e) {
            var process = $(this).val();
            var subprocess = $('select[name=subprocess]');
            subprocess.show();

            $('select[name=subprocess] option').each(function (index, value) {
                var parent = $(this).attr('parent');

                if (process == parent) {
                    $(this).show();
                } else {
                    $(this).hide();
                }

                subprocess.val(-1);
            });
        });
    </script>

@endsection
