@extends('layouts.master')

@section('title', 'Mercadeo - Noticias')

@section('page_title', 'Nueva Noticia')

@if (can_not_do('marketing_news'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('marketing.news.store') }}" id="form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="form-group{{ $errors->first('title') ? ' has-error':'' }}">
                                    <label class="control-label">Título</label>
                                    <input type="text" class="form-control input-sm" name="title" value="{{ old('title') }}">
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('type') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo</label>
                                    <select class="form-control input-sm" name="type">
                                        @foreach (get_news_types() as $key => $type)
                                            <option value="{{ $key }}" {{ old('type') == $key ? 'selected':'' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('type') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="is_active" {{ old('is_active') ? 'checked' : '' }}> Activo
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('detail') ? ' has-error':'' }}">
                                    <label class="control-label">Detalle</label>
                                    <textarea class="form-control input-sm textarea" name="detail" rows="10">{{ old('detail') }}</textarea>
                                    <span class="help-block">{{ $errors->first('detail') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('image') ? ' has-error':'' }}">
                                    <label class="control-label">Imagen <small class="label label-warning">MAX 2 MB</small></label>
                                    <input type="file" name="image">
                                    <span class="help-block">{{ $errors->first('image') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('link_name') ? ' has-error':'' }}">
                                    <label class="control-label">Nombre del Hipervínculo</label>
                                    <input type="text" class="form-control input-sm" name="link_name" value="{{ old('link_name') }}">
                                    <span class="help-block">{{ $errors->first('link_name') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div class="form-group{{ $errors->first('link') ? ' has-error':'' }}">
                                    <label class="control-label">Hipervínculo</label>
                                    <input type="text" class="form-control input-sm" name="link" value="{{ old('link') }}">
                                    <span class="help-block">{{ $errors->first('link') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('link_video') ? ' has-error':'' }}">
                                    <label class="control-label">Hipervínculo de Video</label>
                                    <input type="text" class="form-control input-sm" name="link_video" value="{{ old('link_video') }}">
                                    <span class="help-block">{{ $errors->first('link_video') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('marketing.news.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
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
