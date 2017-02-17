@extends('layouts.master')

@section('title', 'Recursos Humanos -> Calendario')

@section('page_title', 'Editar Grupo de Calendario')

@if (can_not_do('human_resources_calendar'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('human_resources.calendar.date.update', ['id' => $date->id]) }}" id="form" novalidate>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('group_id') ? ' has-error':'' }}">
                                    <label class="control-label">Grupo</label>
                                    <select class="form-control input-sm" name="group_id">
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->id }}" {{ $group->id == $date->group_id ? 'selected':'' }}>{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('group_id') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div class="form-group{{ $errors->first('title') ? ' has-error':'' }}">
                                    <label class="control-label">Titulo</label>
                                    <input type="text" class="form-control input-sm" name="title" value="{{ $date->title }}">
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('startdate') ? ' has-error':'' }}">
                                    <label class="control-label">Fecha de Inicio</label>
                                    <input type="date" class="form-control input-sm" name="startdate" value="{{ $date->startdate->format('Y-m-d') }}">
                                    <span class="help-block">{{ $errors->first('startdate') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('enddate') ? ' has-error':'' }}">
                                    <label class="control-label">Fecha Final</label>
                                    <input type="date" class="form-control input-sm" name="enddate" value="{{ $date->enddate->format('Y-m-d') }}">
                                    <span class="help-block">{{ $errors->first('enddate') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('human_resources.calendar.index') }}"><i class="fa fa-arrow-left"></i> Atras</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (group) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
