@extends('layouts.master')

@section('title', 'Galería de Fotos')

@section('page_title', 'Nueva Galería')

{{-- @if (can_not_do('process_gestidoc'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">

                <div class="panel-body">

                <form method="post" action="{{ route('marketing.gallery.update', ['gallery' => $gallery->id]) }}" id="form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="form-group{{ $errors->first('name') ? ' has-error':'' }}">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="name" maxlength="150" value="{{ $gallery->name }}">
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="is_active" {{ $gallery->is_active ? 'checked' : '' }}> Activo
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('marketing.gallery.index') }}"><i class="fa fa-arrow-left"></i> Atras</a>
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
