@extends('layouts.master')

@section('title', 'Mercadeo - Invitados')

@section('page_title', 'Nuevo Invitado')

@section('contents')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('events.accompanist.update', ['id' => $accompanist->id, 'event' => $event_id]) }}" id="form">
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('names') ? ' has-error':'' }}">
                                    <label class="control-label">Nombres</label>
                                    <input type="text" class="form-control input-sm" name="names" value="{{ $accompanist->names }}">
                                    <span class="help-block">{{ $errors->first('names') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('last_names') ? ' has-error':'' }}">
                                    <label class="control-label">Apellidos</label>
                                    <input type="text" class="form-control input-sm" name="last_names" value="{{ $accompanist->last_names }}">
                                    <span class="help-block">{{ $errors->first('last_names') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('identification_type') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo de Identificación</label>
                                    <select class="form-control input-sm" name="identification_type">
                                        @foreach (get_identification_types() as $key => $identification_type)
                                            <option value="{{ $key }}" {{ $accompanist->identification_type == $key ? 'selected':'' }}>{{ $identification_type }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('identification_type') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('identification') ? ' has-error':'' }}">
                                    <label class="control-label">Identificación</label>
                                    <input type="text" class="form-control input-sm" name="identification" value="{{ $accompanist->identification }}">
                                    <span class="help-block">{{ $errors->first('identification') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('relationship') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo de Relación</label>
                                    <select class="form-control input-sm" name="relationship">
                                        @foreach (get_relationship_types() as $key => $relationship)
                                            <option value="{{ $key }}" {{ $accompanist->relationship == $key ? 'selected':'' }}>{{ $relationship }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('relationship') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('age') ? ' has-error':'' }}">
                                    <label class="control-label">Edad</label>
                                    <input type="number" class="form-control input-sm" name="age" value="{{ $accompanist->age }}">
                                    <span class="help-block">{{ $errors->first('age') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('events.accompanist.index', ['event' => $event_id]) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
