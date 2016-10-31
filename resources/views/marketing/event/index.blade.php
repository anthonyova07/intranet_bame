@extends('layouts.master')

@section('title', 'Eventos')

@section('page_title', 'Mantenimiento de Eventos - ' . get_department_name($department))

@if (can_not_do('marketing_event'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    @include('layouts.partials.event.index', ['department' => $department])

@endsection
