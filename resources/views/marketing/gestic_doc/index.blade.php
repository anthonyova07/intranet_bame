@extends('layouts.master')

@section('title', 'Gestic Doc')

@section('page_title', 'Mantenimiento GesticDoc - ' . get_department_name($department))

@if (can_not_do('marketing_gesticdoc'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    @include('layouts.partials.mant_gesticdoc', ['department' => $department])

@endsection
