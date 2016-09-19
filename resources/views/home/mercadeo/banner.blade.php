@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Banners de Bancamérica')

@section('contents')
    <div class="row">

        <div class="col-xs-12">

            <div class="carousel slide carousel-banners img-thumbnail" data-ride="carousel" data-interval="3000" style="width: 100%;">
                <!-- Indicators -->
                <ol class="carousel-indicators" style="display: none;">
                    <li data-slide-to="0" class="active"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="{{ route('home') . $banner->IMAGE }}">
                        <div class="carousel-caption">
                            {{-- {{ $banner->TITLE }} --}}
                        </div>
                    </div>
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

        <div class="col-xs-12" style="margin-top: 15px;">

            <div class="panel panel-default">
                <div class="panel-body">

                    <h3 style="text-align: center;margin-top: 0px;margin-bottom: 16px;">{{ $banner->TITLE }}</h3>

                    <p style="color: #616365;">
                        {!! $banner->DETAIL !!}
                    </p>

                </div>
            </div>

        </div>

    </div>
@endsection
