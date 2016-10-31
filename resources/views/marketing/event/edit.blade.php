@extends('layouts.master')

@section('title', 'Eventos')

@section('page_title', 'Editar Evento')

@if (can_not_do('marketing_event'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    @include('layouts.partials.event.edit', ['department' => $department])

@endsection
