@extends('layouts.master')

@section('title', 'Eventos')

@section('page_title', 'Nuevo Evento - ' . get_department_name($department))

@if (can_not_do('human_resources_event'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    @include('layouts.partials.event.create', ['department' => $department])

@endsection
