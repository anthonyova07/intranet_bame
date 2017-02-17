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
                    <form method="post" action="{{ route('human_resources.calendar.group.update', ['id' => $group->id]) }}" id="form" novalidate>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('name') ? ' has-error':'' }}">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="name" value="{{ $group->name }}">
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="showinday" {{ $group->showinday ? 'checked' : '' }}> Mostrar en Inicio
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="is_active" {{ $group->is_active ? 'checked' : '' }}> Activo
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                {{-- <div class="form-group{{ $errors->first('color') ? ' has-error':'' }}">
                                    <label class="control-label">Color</label>
                                    <input type="color" class="form-control input-sm" name="color" value="{{ $group->color }}">
                                    <span class="help-block">{{ $errors->first('color') }}</span>
                                </div> --}}
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('backcolor') ? ' has-error':'' }}">
                                    <label class="control-label">Fondo</label>
                                    <input type="color" class="form-control input-sm" name="backcolor" value="{{ $group->backcolor }}">
                                    <span class="help-block">{{ $errors->first('backcolor') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('bordcolor') ? ' has-error':'' }}">
                                    <label class="control-label">Borde</label>
                                    <input type="color" class="form-control input-sm" name="bordcolor" value="{{ $group->bordcolor }}">
                                    <span class="help-block">{{ $errors->first('bordcolor') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('textcolor') ? ' has-error':'' }}">
                                    <label class="control-label">Texto</label>
                                    <input type="color" class="form-control input-sm" name="textcolor" value="{{ $group->textcolor }}">
                                    <span class="help-block">{{ $errors->first('textcolor') }}</span>
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
