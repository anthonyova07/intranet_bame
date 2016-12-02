@extends('layouts.master')

@section('title', 'Mercadeo -> Vacantes')

@section('page_title', 'Mantenimiento de Vacantes')

@if (can_not_do('human_resources_vacant'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Filtros de Búsqueda</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="{{ route('human_resources.vacant.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('term') ? ' has-error':'' }}">
                                    <label class="control-label">Término</label>
                                    <input type="text" class="form-control input-sm" name="term" placeholder="término de busqueda..." value="{{ old('term') }}">
                                    <span class="help-block">{{ $errors->first('term') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('date_from') ? ' has-error':'' }}">
                                    <label class="control-label">Desde</label>
                                    <input type="date" class="form-control input-sm" name="date_from" value="{{ old('date_from') }}">
                                    <span class="help-block">{{ $errors->first('date_from') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('date_to') ? ' has-error':'' }}">
                                    <label class="control-label">Hasta</label>
                                    <input type="date" class="form-control input-sm" name="date_to" value="{{ old('date_to') }}">
                                    <span class="help-block">{{ $errors->first('date_to') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando vacantos...">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a class="btn btn-danger btn-xs" href="{{ route('human_resources.vacant.create') }}">Nuevo</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th style="width: 112px;">Fecha Creación</th>
                                <th style="width: 52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vacancies as $vacant)
                                <tr>
                                    <td>{{ $vacant->name }}</td>
                                    <td>{{ $vacant->created_at }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('human_resources.vacant.edit', ['id' => $vacant->id]) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Editar"
                                            class="naranja">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                        <a
                                            href="{{ route('human_resources.vacant.show', ['id' => $vacant->id]) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Ver Aplicantes">
                                            <i class="fa fa-share fa-fw"></i>
                                        </a>
                                        {{-- <a
                                            onclick="cancel('{{ $vacant->id }}', this)"
                                            href="javascript:void(0)"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Eliminar"
                                            class="rojo link_delete">
                                            <i class="fa fa-close fa-fw"></i>
                                        </a>
                                        <form
                                            action="{{ route('human_resources.vacant.destroy', ['id' => $vacant->id]) }}"
                                            method="post" id="form_eliminar_{{ $vacant->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $vacancies->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Empleados para Posibles Vacantes</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|asc'>
                        <thead>
                            <tr>
                                <th>Empleado</th>
                                <th>Posibles Vacantes</th>
                                <th style="width: 52px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applicants_eligible as $applicant)
                                <tr>
                                    <td>{{ $applicant->names }}</td>
                                    <td>{{ $applicant->vacancies_posible }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('home') . '/files/human_resources/curriculums/' . $applicant->file_name }}"
                                            target="__blank"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Ver Curriculum">
                                            <i class="fa fa-eye fa-fw"></i>
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
        $('#form').submit(function (vacant) {
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
