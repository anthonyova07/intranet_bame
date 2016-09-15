@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Bienvenid@ a la Intranet Bancamérica')

@section('contents')
    <div class="row">
        <div class="col-xs-12">

            <div class="col-xs-5 col-noticias">
                @if ($noticia_columna)
                    <div class="row titulo-columna img-rounded">
                        {{ $noticia_columna->TITLE }}
                    </div>
                    <div class="row text-center" style="margin-bottom: 10px;">
                        <img class="img-thumbnail" src="{{ route('home') . $noticia_columna->IMAGE }}">
                    </div>
                    <div class="row parrafo-columna text-justify">
                        <p>{!! substr($noticia_columna->DETAIL, 0, 800) !!}</p>
                    </div>
                    <div class="row text-center">
                        <a href="{{ route('noticia', ['id' => $noticia_columna->ID]) }}" class="btn btn-info btn-xs">Ver Más</a>
                    </div>
                @endif
            </div>

            <div class="col-xs-7">

                <div class="col-xs-12" style="padding: 0 0 0 0;margin-left: 12px;">

                    <div class="carousel slide carousel-banners img-thumbnail" data-ride="carousel" data-interval="3000" style="width: 100%;">
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
                                    <img src="{{ route('home') . $banner->IMAGE }}">
                                    <div class="carousel-caption" style="right: 0;left: 0;margin-bottom: -45px;">
                                        <a href="{{ route('banner', ['id' => $banner->ID]) }}" class="btn btn-info btn-xs">Ver Banners</a>
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

                <div class="col-xs-12" style="margin-top: 20px;padding: 0 0 0 0;margin-left: 12px;">

                    <div class="carousel slide carousel-noticias img-thumbnail" data-ride="carousel" data-interval="5000" style="width: 100%;">
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
                                    <div class="carousel-caption carousel-caption-noticias" style="right: 0;left: 0;margin-bottom: -45px;">
                                        <a data-toggle="tooltip" title="Click para más detalles" href="{{ route('noticia', ['id' => $noticia->ID]) }}" class="btn btn-danger btn-sm">{{ substr($noticia->TITLE, 0, 85) . '...' }}</a>
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

    <div class="row" style="border-top: 1px solid #777;margin-top: 8px;border-width: 5px;">
        <div class="col-xs-12">

            <div class="col-xs-4">
                uno
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
