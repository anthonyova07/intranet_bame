@extends('layouts.master')

@section('title', 'Recursos Humanos -> Solicitudes')

@section('page_title', 'Solicitud de Recursos Humanos #' . $human_resource_request->reqnumber)

{{-- @if (can_not_do('human_resource_request'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    @include('human_resources.request.panels.' . strtolower($human_resource_request->reqtype) . '_show', [
        'human_resource_request' => $human_resource_request,
        'statuses' => $statuses,
    ])

@endsection
