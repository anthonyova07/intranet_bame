    @extends('layouts.master')

@section('title', 'Mercadeo - Noticias')

@section('page_title', 'Editar Noticia')

@if (can_not_do('mercadeo_noticias'))
    @section('contents')
        @include('partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('mercadeo::noticias::editar', ['id' => $noticia->ID]) }}" id="form_consulta" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="form-group{{ $errors->first('title') ? ' has-error':'' }}">
                                    <label class="control-label">Título</label>
                                    <input type="text" class="form-control" name="title" value="{{ $noticia->TITLE }}">
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('type') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo</label>
                                    <select class="form-control" name="type">
                                        @foreach (get_news_types() as $key => $type)
                                            <option value="{{ $key }}" {{ $noticia->TYPE == $key ? 'selected':'' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('type') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('detail') ? ' has-error':'' }}">
                                    <label class="control-label">Detalle</label>
                                    <textarea class="form-control" name="detail" rows="10">{{ str_replace('<br />', '', $noticia->DETAIL) }}</textarea>
                                    <span class="help-block">{{ $errors->first('detail') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="form-group{{ $errors->first('image') ? ' has-error':'' }}">
                                    <label class="control-label">Imagen</label>
                                    <input type="file" name="image">
                                    <span class="help-block">{{ $errors->first('image') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('respost') ? ' has-error':'' }}">
                                    <label>
                                        <input type="checkbox" name="repost" data-toggle="tooltip" title="Re-Publicar esta noticia" style="margin-top: 23px;"> Re-Publicar
                                    </label>
                                    <span class="help-block">{{ $errors->first('repost') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <a href="{{ route('mercadeo::noticias::lista') }}" class="btn btn-default btn-sm">Cancelar</a>
                        <button type="submit" class="btn btn-danger btn-sm" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form_consulta').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
