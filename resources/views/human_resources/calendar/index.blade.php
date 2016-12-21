@extends('layouts.master')

@section('title', 'Recursos Humanos -> Calendario')

@section('page_title', 'Mantenimiento de Calendario ')

{{-- @if (can_not_do('human_resources_vacant'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Fechas</h3>
                </div>
                <div class="panel-body">
                    <a class="btn btn-danger btn-xs" href="{{ route('human_resources.calendar.date.create') }}">Nuevo</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                        <thead>
                            <tr>
                                <th>Grupo</th>
                                <th>Nombre</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Final</th>
                                <th style="width: 52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dates as $date)
                                <tr>
                                    <td>{{ $date->group->name }}</td>
                                    <td>{{ $date->title }}</td>
                                    <td>{{ $date->startdate }}</td>
                                    <td>{{ $date->enddate }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('human_resources.calendar.date.edit', ['id' => $date->id]) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Editar"
                                            class="naranja">
                                            <i class="fa fa-edit fa-fw"></i>
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

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Grupos</h3>
                </div>
                <div class="panel-body">
                    <a class="btn btn-danger btn-xs" href="{{ route('human_resources.calendar.group.create') }}">Nuevo</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th style="width: 52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groups as $group)
                                <tr>
                                    <td>{{ $group->name }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('human_resources.calendar.group.edit', ['id' => $group->id]) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Editar"
                                            class="naranja">
                                            <i class="fa fa-edit fa-fw"></i>
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

    <script type="text/javascript">
        $('#form').submit(function () {
            $('#btn_submit').button('loading');
        });

        function cancel(id, el)
        {
            res = confirm('Realmente desea eliminar este vacanto?');

            if (!res) {
                vacant.prvacantDefault();
                return;
            }

            $(el).remove();

            $('#form_eliminar_' + id).submit();
        }
    </script>

@endsection
