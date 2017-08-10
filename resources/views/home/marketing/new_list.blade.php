@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Listado de Noticias')

@section('contents')
    <div class="row">

        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    @foreach ($news as $new)
                        <div class="well well-sm">
                            <div class="media">
                                <div class="media-left">
                                    @if ($new->imgbanner == '' || !$new->imgbanner)
                                        <img src="{{ route('home') . $new->image . '?id=' . uniqid() }}" style="height: 150px;margin: auto;">
                                    @else
                                        <img src="{{ route('home') . $new->imgbanner . '?id=' . uniqid() }}" style="height: 150px;margin: auto;">
                                    @endif
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">{{ html_entity_decode($new->title) }}</h4>
                                    {{ str_limit(strip_tags(html_entity_decode($new->detail)), 500) }}
                                    <a href="{{ route('home.news', ['id' => $new->id]) }}">Seguir Leyendo</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{ $news->links() }}

                </div>
            </div>
        </div>

    </div>
@endsection
