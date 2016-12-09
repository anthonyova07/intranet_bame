@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Galería de Fotos' . ($gallery ? (': ' . $gallery->name) : ''))

@section('contents')
    <div class="row">

        @if ($galleries->count())

            <div class="row">
                <div class="col-xs-8 col-xs-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='2|desc'>
                                <thead>
                                    <tr>
                                        <th style="width: 85px;">Portada</th>
                                        <th>Galería</th>
                                        <th style="width: 40px;">Fecha</th>
                                        <th style="width: 25px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($galleries as $gallery)
                                        <tr>
                                            <td><img style="width: 100px;" alt="No encontrada" src="{{ route('home') . '/files/gallery/' . $gallery->id . '/' . $gallery->image }}"></td>
                                            <td>{{ $gallery->name }}</td>
                                            <td>{{ $gallery->galdate->format('Y-m-d') }}</td>
                                            <td align="center">
                                                <a
                                                    href="{{ route('home.gallery', ['gallery' => $gallery->id]) }}"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Ver Imagenes">
                                                    <i class="fa fa-share fa-fw"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        @else

            <div class="panel panel-default">
                <div class="panel-body">
                <a class="btn btn-info btn-xs" href="{{ route('home.gallery') }}"><i class="fa fa-arrow-left"></i> Atras</a>
                </div>
            </div>

            @foreach ($images as $index => $image)
                @if (strpos($image->file, 'portada') === false)
                    <div class="col-xs-4">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding: 0px;overflow: hidden;height: 214px;">
                                <img style="cursor: -webkit-zoom-in;" style="" class="img-thumbnail image" index="{{ $index }}" src="{{ $image->url }}">
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            @if ($gallery)
                <div class="modal fade">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="padding: 0 0 0 10px;">
                                <button style="margin: -1px 10px 0 0;font-size: 40px;" type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                <a data-toggle="tooltip" title="Descargar" href="" download style="margin: 8px 10px 0 0;font-size: 27px;font-weight: 700;line-height: 1;text-shadow: 0 1px 0 #fff;" class="pull-right" id="link-download"><i class="fa fa-download" style="color: #d82f27;"></i></a>
                                <h4>{{ $gallery->name }}</h4>
                            </div>
                            <div class="modal-body" style="padding: 0px;">
                                <div class="row">
                                    <div class="col-xs-12 text-center" style="padding: 0px;">
                                        <img class="img-thumbnail" id="image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <script type="text/javascript">
                $('.image').click(function (event) {
                    $('#image')
                    .attr('src', $(this).attr('src'))
                    .attr('index', $(this).attr('index'));

                    $('#link-download').attr('href', $(this).attr('src'));
                    $('.modal').modal();
                });

                $('#image').click(function (e) {
                    var index = parseInt($(this).attr('index'));

                    var image = $('.image').get(index + 1);
                    if (image !== undefined) {
                        $(this).attr('src', $(image).attr('src'));

                        $('#link-download').attr('href', $(image).attr('src'));

                        $(this).attr('index', index + 1);
                    }
                });

                $('body').keyup(function (e) {
                    if ($('.modal').hasClass('in')) {
                        var index = parseInt($('#image').attr('index'));

                        if (e.key == 'ArrowRight') {
                            var image = $('.image').get(index + 1);

                            if (image != undefined) {
                                $('#image').attr('src', $(image).attr('src'));

                                $('#link-download').attr('href', $(image).attr('src'));

                                $('#image').attr('index', parseInt($('#image').attr('index')) + 1);
                            }
                        }

                        if (e.key == 'ArrowLeft') {
                            if (index > 0) {
                                var image = $('.image').get((index == 0) ? 0 : (index - 1));

                                if (image != undefined) {
                                    $('#image').attr('src', $(image).attr('src'));

                                    $('#link-download').attr('href', $(image).attr('src'));

                                    $('#image').attr('index', parseInt($('#image').attr('index')) - 1);
                                }
                            }
                        }
                    }
                });
            </script>

        @endif

    </div>
@endsection
