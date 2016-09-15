@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Banners de Bancamérica')

@section('contents')
    <div class="row">

        <div class="col-xs-12">

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
                            <div class="carousel-caption">
                                {{-- {{ $banner->TITLE }} --}}
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
@endsection
