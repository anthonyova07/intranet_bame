@extends('layouts.master')

@section('title', 'Galería de Fotos')

@section('page_title', 'Nueva Galería')

@if (can_not_do('marketing_gallery'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">

                <div class="panel-body">

                <form method="post" action="{{ route('marketing.gallery.store') }}" id="form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('name') ? ' has-error':'' }}">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="name" maxlength="150" value="{{ old('name') }}">
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('image') ? ' has-error':'' }}">
                                    <label class="control-label">Imagen de la Galería</label>
                                    <input type="file" class="input-sm" name="image">
                                    <span class="help-block">{{ $errors->first('image') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-5">
                                <div class="form-group{{ $errors->first('galdate') ? ' has-error':'' }}">
                                    <label class="control-label">Fecha del Evento</label>
                                    <input type="date" class="form-control input-sm" name="galdate" value="{{ old('galdate') }}">
                                    <span class="help-block">{{ $errors->first('galdate') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="is_active" {{ old('is_active') ? 'checked' : '' }}> Activo
                                    </label>
                                </div>
                            </div>
                        </div>
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
