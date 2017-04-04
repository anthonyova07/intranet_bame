@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Detalle de la Noticia')

@section('contents')
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
              <div class="panel-body">
                  <input type="text" id="search_field" placeholder="Búsqueda rápida" class="form-control input-lg" autofocus>
              </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-xs-12">

            <div class="panel-group" id="faqs">
                @foreach ($themes as $index => $theme)
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding: 9px 15px;">
                            <h4 class="panel-title" style="font-size: 25px;">
                                <a data-toggle="collapse" data-parent="#faqs" href="#{{ $theme->id }}">
                                    {!! html_entity_decode($theme->name) !!}
                                </a>
                            </h4>
                        </div>
                        <div id="{{ $theme->id }}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="panel-group" id="{{ $index }}">
                                    @foreach ($theme->questions as $question)
                                        <div class="panel panel-default">
                                            <div class="panel-heading" style="padding: 6px 15px;background-color:#616365">
                                                <h4 class="panel-title" style="font-size: 20px;">
                                                    <a data-toggle="collapse" data-parent="#{{ $index }}" href="#{{ $question->id }}">
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
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <script>
    $('#search_field').keyup(function (e) {
        var str = $(this).val().trim().toLowerCase();

        if (str != '') {
            $('#faqs .panel').each(function (index, value) {
                var tag = $(value);

                var text = tag.children('div').children('h4').children('a').each(function (index, value) {
                    var a = $(value);

                    if (a.text().trim().toLowerCase().indexOf(str) >= 0) {
                        tag.show('slow');
                    } else {
                        tag.hide('slow');
                    }
                });
            });
        } else {
            $('#faqs .panel').each(function (index, value) {
                $(value).show('slow');
            });
        }
    });

    </script>
@endsection
