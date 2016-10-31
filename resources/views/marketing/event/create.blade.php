@extends('layouts.master')

@section('title', 'Mercadeo - Eventos')

@section('page_title', 'Nuevo Evento - ' . get_department_name($department))

@if (can_not_do('marketing_event'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    @include('layouts.partials.event.create', ['department' => $department])

@endsection
