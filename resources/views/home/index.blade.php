@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Bienvenid@ a la Intranet Bancamérica')

@section('contents')
    <div class="row">
        <div class="col-xs-12">

            <div class="col-xs-5 col-noticias">
                @if ($noticia_columna)
                    <div class="row titulo-columna">
                        La Columna del Presidente
                    </div>
                    <div class="row text-center" style="margin-bottom: 10px;">
                        <img class="img-thumbnail" style="max-width: 280px" src="{{ route('home') . $noticia_columna->IMAGE }}">
                    </div>
                    <div class="row parrafo-columna text-justify">
                        <p style="height: 220px;max-height: 220px;"><b>{{ substr($noticia_columna->TITLE, 0, 80) . '...' }}</b> {!! str_replace('<br />', ' ', substr($noticia_columna->DETAIL, 0, 600))  . '...' !!}</p>
                    </div>
                    <div class="row text-center">
                        <a href="{{ route('mercadeo::noticia', ['id' => $noticia_columna->ID]) }}" class="btn btn-info btn-xs">Ver Más</a>
                    </div>
                @endif
            </div>

            <div class="col-xs-7">

                <div class="row" style="margin-bottom: 13px;">
                    <div class="col-xs-12" style="margin-left: 12px;">

                        <div class="carousel slide carousel-banners" data-ride="carousel" data-interval="3000" style="width: 100%;height: 226px;margin-top: 9px;">
                            <!-- Indicators -->
                            <ol class="carousel-indicators" style="display: none;">
                                @foreach ($noticias_banners as $index => $banner)
                                    <li data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active':'' }}"></li>
                                @endforeach
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                @foreach ($noticias_banners as $index => $banner)
                                    <div class="item {{ $index == 0 ? 'active':'' }}">
                                        <img src="{{ route('home') . $banner->IMAGE }}" style="height: 232px;margin: auto;">
                                        <div class="carousel-caption" style="right: 0;left: 0;margin-bottom: -44px;">
                                            <a href="{{ route('mercadeo::banner', ['id' => $banner->ID]) }}" class="btn btn-info btn-xs">Ver Detalle</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Controls -->
                            <a class="left carousel-control" href="javascript:void(0)" onclick="$('.carousel-banners').carousel('prev')" data-slide="prev">
                                <span class="icon-prev"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control"  href="javascript:void(0)" onclick="$('.carousel-banners').carousel('next')" data-slide="next">
                                <span class="icon-next"></span>
                                <span class="sr-only">Next</span>
                            </a>

                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12" style="margin-top: 5px;margin-left: 12px;">

                        <div class="carousel slide carousel-noticias" data-ride="carousel" data-interval="5000" style="width: 100%;height: 281px;margin-top: 9px;">
                            <!-- Indicators -->
                            <ol class="carousel-indicators" style="display: none;">
                                @foreach ($noticias as $index => $noticia)
                                    <li data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active':'' }}"></li>
                                @endforeach
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                @foreach ($noticias as $index => $noticia)
                                    <div class="item {{ $index == 0 ? 'active':'' }}">
                                        <img src="{{ route('home') . $noticia->IMAGE }}" style="height: 280px;margin: auto;">
                                        <div class="carousel-caption carousel-caption-noticias" style="right: 0;left: 0;margin-bottom: -50px;">
                                            <a data-toggle="tooltip" title="Click para más detalles" href="{{ route('mercadeo::noticia', ['id' => $noticia->ID]) }}" class="btn btn-info btn-xs">{{ substr($noticia->TITLE, 0, 85) . '...' }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Controls -->
                            <a class="left carousel-control" href="javascript:void(0)" onclick="$('.carousel-noticias').carousel('prev')" data-slide="prev">
                                <span class="icon-prev"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control"  href="javascript:void(0)" onclick="$('.carousel-noticias').carousel('next')" data-slide="next">
                                <span class="icon-next"></span>
                                <span class="sr-only">Next</span>
                            </a>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row" style="border-top: 1px solid #777;margin-top: 8px;border-width: 5px;">
        <div class="col-xs-12">

            <div class="col-xs-4" style="padding-left: 0;">
                <div class="panel panel-default" style="margin-top: 16px;">

                    <div class="panel-body text-center">
                        <img src="{{ route('home') . '/mercadeo/coco/rompete_el_coco.png' }}" style="width: 220px;">
                    </div>

                    <div class="panel-body text-center">
                        <h3 style="padding-top: 0;color: #da291c;">{{ $coco->get()->title }}</h3>
                    </div>

                    @if ($coco->get()->active)

                        <div class="panel-body text-center">
                            <label class="control-label text-center label label-info" style="font-size: 24px;">Descripción</label>
                            <ul class="list-group text-left" style="box-shadow: 0 0 0 0;margin-top: 20px;">
                                @foreach ($coco->get()->descriptions->sortBy('order') as $description)
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="javascript:void(0)">
                                                <span class="badge btn-info" style="font-size: 35px;width: 40px;">{{ $description->order }}</span>
                                            </a>
                                        </div>
                                        <div class="media-body" style="font-weight: bold;">
                                            {{ $description->description }}
                                        </div>
                                    </div>
                                @endforeach
                            </ul>
                        </div>

                        <div class="panel-body text-center">
                            <label class="control-label text-center label label-warning" style="font-size: 24px;">Premios</label>
                            <ul class="list-group text-left" style="box-shadow: 0 0 0 0;margin-top: 20px;">
                                @foreach ($coco->get()->awards->sortBy('order') as $award)
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="javascript:void(0)">
                                                <span class="badge btn-warning" style="font-size: 35px;width: 40px;">{{ $award->order }}</span>
                                            </a>
                                        </div>
                                        <div class="media-body" style="font-weight: bold;vertical-align: middle;">
                                            {{ $award->award }}
                                        </div>
                                    </div>
                                @endforeach
                            </ul>
                        </div>

                        <div class="panel-body text-right" style="margin-top: -38px;">
                            <a href="{{ route('mercadeo::coco') }}" class="btn btn-success btn-sm" style="margin-top: -12px;">Enviar Idea...</a>
                        </div>

                    @else

                        <div class="panel-body text-center">
                            <label class="control-label text-center label label-danger" style="font-size: 24px;">Concurso no Disponible</label>
                        </div>

                    @endif

                </div>
            </div>

            <div class="col-xs-4">
                dos
            </div>

            <div class="col-xs-4">
                tres
            </div>

        </div>
    </div>
@endsection
