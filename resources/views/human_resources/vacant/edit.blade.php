@extends('layouts.master')

@section('title', 'Recuersos Humanos - Vacantes')

@section('page_title', 'Editar Vacante')

@if (can_not_do('human_resources_vacant'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('human_resources.vacant.update', ['id' => $vacant->id]) }}" id="form" novalidate>
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="form-group{{ $errors->first('name') ? ' has-error':'' }}">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="name" value="{{ $vacant->name }}">
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="is_active" {{ $vacant->is_active ? 'checked' : '' }}> Activo
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('detail') ? ' has-error':'' }}">
                                    <label class="control-label">Detalle</label>
                                    <textarea class="form-control input-sm textarea" name="detail" rows="10">{{ str_replace('<br />', '', $vacant->detail) }}</textarea>
                                    <span class="help-block">{{ $errors->first('detail') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('human_resources.vacant.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (vacant) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
