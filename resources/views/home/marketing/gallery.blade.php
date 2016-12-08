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
                            <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|asc'>
                                <thead>
                                    <tr>
                                        <th>Galería</th>
                                        <th style="width: 25px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($galleries as $gallery)
                                        <tr>
                                            <td>{{ $gallery->name }}</td>
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

            @foreach ($images as $index => $image)
                <div class="col-xs-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <img style="cursor: -webkit-zoom-in;" class="img-thumbnail image" index="{{ $index }}" src="{{ $image->url }}">
                        </div>
                    </div>
                </div>
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
                    $('#image').attr('src', $(this).attr('src'));
                    $('#image').attr('index', $(this).attr('index'));
                    $('#link-download').attr('href', $(this).attr('src'));
                    $('.modal').modal();
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
