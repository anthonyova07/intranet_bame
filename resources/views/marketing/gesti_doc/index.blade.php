@extends('layouts.master')

@section('title', 'GestiDoc')

@section('page_title', 'Mantenimiento GestiDoc - ' . get_department_name($department))

@if (can_not_do('marketing_gestidoc'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    @include('layouts.partials.mant_gestidoc', ['department' => $department])

@endsection
