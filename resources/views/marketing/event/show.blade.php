@extends('layouts.master')

@section('title', 'Eventos')

@section('page_title', 'Suscriptores del Evento: ' . $event->title)

@if (can_not_do('marketing_event'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    @include('layouts.partials.event.show', ['department' => $department])

@endsection
