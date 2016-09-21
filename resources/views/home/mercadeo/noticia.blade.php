@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Detalle de la Noticia')

@section('contents')
    <div class="row">

        <div class="col-xs-12">

            <div class="panel panel-default">

                <div class="panel-body">

                    <h3 style="text-align: center;margin-top: 0px;margin-bottom: 16px;">{{ $noticia->TITLE }}</h3>

                    <img class="img-thumbnail pull-left" src="{{ route('home') . $noticia->IMAGE }}" style="max-height: 380px;margin: 0px 15px 15px 0px;">

                    <p style="color: #616365;" class="text-justify">
                        {!! $noticia->DETAIL !!}
                    </p>

                </div>

            </div>

        </div>

    </div>
@endsection
