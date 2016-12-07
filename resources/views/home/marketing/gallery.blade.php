@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Galería de Fotos: ' . $gallery->name)

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

            @foreach ($images as $image)
                <div class="col-xs-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <img style="cursor: pointer;" class="img-thumbnail image" src="{{ $image->url }}">
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="modal fade">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="padding: 0 0 0 10px;">
                            <button style="margin: -1px 10px 0 0;font-size: 40px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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

            <script type="text/javascript">
                $('.image').click(function (event) {
                    $('#image').attr('src', $(this).attr('src'));
                    $('.modal').modal({
                        keyboard: false
                    });
                });
            </script>

        @endif

    </div>
@endsection
