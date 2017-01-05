@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Detalle de la Noticia')

@section('contents')
    <div class="row">

        <div class="col-xs-12">

            <div class="panel panel-default">

                <div class="panel-body">

                    <h3 style="text-align: center;margin-top: 0px;margin-bottom: 16px;">{{ html_entity_decode($new->title) }}</h3>

                    <img class="img-thumbnail pull-left" src="{{ route('home') . $new->image }}" style="max-height: 380px;margin: 0px 30px 15px 0px;">

                    <div style="color: #616365;">
                        {!! html_entity_decode($new->detail) !!}
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
