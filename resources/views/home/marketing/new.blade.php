@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Detalle de la Noticia')

@section('contents')
    <div class="row">

        <div class="col-xs-12">

            <div class="panel panel-default">

                <div class="panel-body">

                    <div class="col-xs-6">
                        <h3 style="text-align: center;margin-top: 0px;margin-bottom: 16px;">{{ html_entity_decode($new->title) }}</h3>

                        @if ($new->link_video == '' || !$new->link_video)
                            <img class="img-thumbnail pull-left" src="{{ route('home') . $new->image }}">
                        @else
                            <video autoplay controls class="img-thumbnail video-thumbnail" src="{{ $new->link_video }}"></video>
                        @endif
                    </div>

                    <div class="col-xs-6">
                        <div style="color: #616365;">
                            {!! html_entity_decode($new->detail) !!}

                            <p>
                                <a href="{{ $new->link }}" target="__blank">{{ ($new->link_name || $new->link_name <> '' ? $new->link_name : $new->link) }}</a>
                            </p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
