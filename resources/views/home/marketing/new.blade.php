@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Detalle de la Noticia')

@section('contents')
    <div class="row">

        <div class="col-xs-12">

            <div class="panel panel-default">

                <div class="panel-body">

                    <div class="col-xs-{{ $new->hasDetail() ? '6' : '12' }} text-center">
                        <h3 style="margin-top: 0px;margin-bottom: 16px;">{{ html_entity_decode($new->title) }}</h3>

                        @if ($new->link_video == '' || !$new->link_video)
                            @if ($new->image == '' || !$new->image)
                                <img style="cursor: zoom-in;" class="image img-thumbnail{{ $new->hasDetail() ? ' pull-left' : '' }}" src="{{ route('home') . $new->imgbanner . '?id=' . uniqid() }}">
                            @else
                                <img style="cursor: zoom-in;" class="image img-thumbnail{{ $new->hasDetail() ? ' pull-left' : '' }}" src="{{ route('home') . $new->image . '?id=' . uniqid() }}">
                            @endif
                        @else
                            <video autoplay controls class="img-thumbnail video-thumbnail" src="{{ $new->link_video . '?id=' . uniqid() }}"></video>
                        @endif

                        <p>
                            <a style="font-weight: bold;font-size: 16px;text-decoration: underline;color: #FF8849;" href="{{ $new->link }}" target="__blank">{{ ($new->link_name || $new->link_name <> '' ? $new->link_name : $new->link) }}</a>
                        </p>
                    </div>

                    @if ($new->hasDetail())
                        <div class="col-xs-6">
                            <div style="color: #616365;text-align: justify;">
                                {!! html_entity_decode($new->detail) !!}
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </div>

        <div class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 0 0 0 10px;">
                        <button style="margin: -1px 10px 0 0;font-size: 40px;" type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        {{-- <a data-toggle="tooltip" title="Descargar" href="" download style="margin: 8px 10px 0 0;font-size: 27px;font-weight: 700;line-height: 1;text-shadow: 0 1px 0 #fff;" class="pull-right" id="link-download"><i class="fa fa-download" style="color: #d82f27;"></i></a> --}}
                        <h4>{{ html_entity_decode($new->title) }}</h4>
                    </div>
                    <div class="modal-body" style="padding: 0px;">
                        <div class="row">
                            <div class="col-xs-12 text-center" style="padding: 0px;">
                                @if ($new->image == '' || !$new->image)
                                    <img class="img-thumbnail" src="{{ route('home') . $new->imgbanner . '?id=' . uniqid() }}">
                                @else
                                    <img class="img-thumbnail" src="{{ route('home') . $new->image . '?id=' . uniqid() }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $('.image').click(function (event) {
                $('.modal').modal();
            });
        </script>

    </div>
@endsection
