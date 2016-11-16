@extends('layouts.master')

@section('title', 'Mercadeo -> Vacantes')

@section('page_title', 'Aplicantes de la Vacante: ' . $vacant->name)

@if (can_not_do('human_resources_vacant'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">

                    {{-- <a class="pull-right label label-warning" style="font-size: 13px;" target="__blank" href="{{ route('home', ['vacant' => $vacant->id, 'format' => 'pdf']) }}">Imprimir</a> --}}

                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='1|desc'>
                        <thead>
                            <tr>
                                <th>Correo</th>
                                <th>Nombre</th>
                                <th style="width: 68px">Curriculum</th>
                                {{-- <th style="width: 52px"></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applicants as $applicant)
                                <tr>
                                    <td><a data-toggle="tooltip" title="Click para contactar empleado" href="mailto:{{ $applicant->username . '@bancamerica.com.do' }}?Subject=Vacante {{ $vacant->name }}">{{ $applicant->username . '@bancamerica.com.do' }}</a></td>
                                    <td>{{ $applicant->names }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('home') . '/files/human_resources/curriculums/' . $applicant->file_name }}"
                                            target="__blank"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Ver Curriculum">
                                            <i class="fa fa-eye fa-fw"></i>
                                        </a>
                                        <a
                                            href="javascript:void(0)"
                                            data-toggle="popover"
                                            data-placement="top"
                                            title="Empleado elegible"
                                            data-content="
                                            <form action='{{ route('human_resources.vacant.eligible', ['vacant' => $applicant->vacant_id, 'applicant' => $applicant->username]) }}' method='post'>
                                                <div class='row'>
                                                    <div class='col-xs-12'>
                                                        <div class='form-group'>
                                                            <label class='control-label'>Posibles Vacantes</label>
                                                            <input type='text' class='form-control input-sm' name='vacancies_posible'>
                                                        </div>
                                                        {{ str_replace('"', '\'', csrf_field()) }}
                                                        <input type='submit' class='btn btn-danger btn-xs' value='Guardar' style='margin-top: 10px;'>
                                                    </div>
                                                </div>
                                            </form>"
                                            data-placement="left"
                                            style="color: green;">
                                            <i class="fa fa-plus-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection
