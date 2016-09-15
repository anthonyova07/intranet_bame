@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Detalle de la Noticia')

@section('contents')
    <div class="row">

        <div class="col-xs-12">

            <div class="panel panel-default">

                <div class="panel-body">

                    <h3 style="text-align: center;">{{ $noticia->TITLE }}</h3>

                    <img class="img-thumbnail pull-left" src="{{ route('home') . $noticia->IMAGE }}" style="height: 380px;margin: 0px 15px 15px 0px;">

                    <p>
                        {!! $noticia->DETAIL !!}
                    </p>

                </div>

            </div>

        </div>

    </div>
@endsection
