@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Detalle de la Noticia')

@section('contents')
    <div class="row">

        <div class="col-xs-8 col-xs-offset-2">

            @foreach ($themes as $theme)
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding: 9px 15px;">
                        <h4 class="panel-title" style="font-size: 25px;">
                            <a data-toggle="collapse" href="#{{ $theme->id }}">
                                {!! html_entity_decode($theme->name) !!}
                            </a>
                        </h4>
                    </div>
                    <div id="{{ $theme->id }}" class="panel-collapse collapse">
                        <div class="panel-body">

                            @foreach ($theme->questions as $question)
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="padding: 6px 15px;">
                                        <h4 class="panel-title" style="font-size: 20px;">
                                            <a data-toggle="collapse" data-parent="#{{ $theme->id }}" href="#{{ $question->id }}">
                                                {!! html_entity_decode($question->question) !!}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="{{ $question->id }}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            {!! html_entity_decode($question->answer) !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
