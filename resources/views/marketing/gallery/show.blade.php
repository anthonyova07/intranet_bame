@extends('layouts.master')

@section('title', 'Galería de Fotos')

@section('page_title', 'Fotos de la Álbum: ' . $gallery->name)

@if (can_not_do('marketing_gallery'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Carga de Imágenes</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="{{ route('marketing.gallery.upload', ['gallery' => $gallery->id]) }}" id="form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('images') ? ' has-error':'' }}">
                                    <label class="control-label">Imágenes <div class="label label-warning"> MAX: 10MB</div></label>
                                    <input type="file" name="images[]" multiple>
                                    <span class="help-block">{{ $errors->first('images') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Subiendo archivos...">Subir</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">

                <div class="panel-body">
                    <a class="btn btn-info btn-xs"
                        href="{{ route('marketing.gallery.index') }}"><i class="fa fa-arrow-left"></i> Atras</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='1|asc'>
                        <thead>
                            <tr>
                                <th style="width: 85px;">Imagen</th>
                                <th>Nombre</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($images as $index => $image)
                                @if (strpos($image->file, 'portada') === false)
                                    <tr>
                                        <td>
                                            <img style="width: 100px;" src="{{ $image->url }}">
                                        </td>
                                        <td>{{ $image->file }}</td>
                                        <td style="vertical-align: middle;text-align: center;font-size: 20px;">
                                            <a
                                                download
                                                href="{{ $image->url }}"
                                                target="_blank"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Descargar {{ str_replace('_', ' ', $image->file) }}">
                                                <i class="fa fa-download fa-fw"></i>
                                            </a>
                                            <a
                                                onclick="cancel('{{ $index }}', this)"
                                                href="javascript:void(0)"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Eliminar {{ str_replace('_', ' ', $image->file) }}"
                                                class="rojo link_delete">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                            <form
                                                action="{{ route('marketing.gallery.delete_image', ['gallery' => $gallery->id, 'image' => $image->file]) }}"
                                                method="post" id="form_eliminar_{{ $index }}">
                                                <input type="hidden" name="folder" value="{{ Request::get('folder') }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        function cancel(id, el)
        {
            res = confirm('Realmente desea eliminar este archivo?');

            if (!res) {
                event.preventDefault();
                return;
            }

            $(el).remove();

            $('#form_eliminar_' + id).submit();
        }
    </script>

@endsection
