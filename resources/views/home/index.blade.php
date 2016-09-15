@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Bienvenid@ a la Intranet Bancamérica')

@section('contents')
    <div class="row">
        <div class="col-xs-12">

            <div class="col-xs-5 col-noticias">
                <div class="row titulo-columna img-rounded">
                    {{ $noticia_columna->TITLE }}
                </div>
                <div class="row text-center" style="margin-bottom: 10px;">
                    <img class="img-rounded" src="{{ route('home') . $noticia_columna->IMAGE }}" style="width: 402px;height: 190px;">
                </div>
                <div class="row parrafo-columna text-justify">
                    <p>{!! $noticia_columna->DETAIL !!}</p>
                </div>
            </div>

            <div class="col-xs-7">

                <div class="carousel slide" data-ride="carousel" data-interval="5000">
                    <!-- Indicators -->
                    <ol class="carousel-indicators" style="display: none;">
                        @foreach ($noticias_banners as $index => $banner)
                            <li data-target="#banners" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active':'' }}"></li>
                        @endforeach
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        @foreach ($noticias_banners as $index => $banner)
                            <div class="item {{ $index == 0 ? 'active':'' }}">
                                <img src="{{ route('home') . $banner->IMAGE }}">
                                <div class="carousel-caption">
                                    {{ $banner->TITLE }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="javascript:void(0)" onclick="$('.carousel').carousel('prev')" data-slide="prev">
                        <span class="icon-prev"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control"  href="javascript:void(0)" onclick="$('.carousel').carousel('next')" data-slide="next">
                        <span class="icon-next"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
