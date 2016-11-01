@extends('layouts.master')

@section('title', 'Gesti Doc')

@section('page_title', 'Mantenimiento GestiDoc - ' . get_department_name($department))

@if (can_not_do('human_resources_gesticdoc'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    @include('layouts.partials.mant_gestidoc', ['department' => $department])

@endsection
