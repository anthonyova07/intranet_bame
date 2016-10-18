@extends('layouts.master')

@section('title', 'Gestic DOC')

@section('page_title', 'Mantenimiento GesticDoc - ' . get_department_name($department))

@if (can_not_do('human_resources_gesticdoc'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    @include('layouts.partials.mant_gesticdoc', ['department' => $department])

@endsection
