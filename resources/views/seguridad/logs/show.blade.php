@extends('layouts.master')

@section('title', 'Seguridad -> Logs')

@section('page_title', 'Logs del Sistema')

{{-- @if (can_not_do('clientes_ncf'))
    @section('contents')
        @include('partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Filtros de Búsqueda</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="{{ route('seguridad::logs::show') }}" id="form_consulta">
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('id') ? ' has-error':'' }}">
                                    <label class="control-label">ID</label>
                                    <input type="text" class="form-control" name="id" placeholder="###" value="{{ old('id') }}">
                                    <span class="help-block">{{ $errors->first('id') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('usuario') ? ' has-error':'' }}">
                                    <label class="control-label">Usuario</label>
                                    <input type="text" class="form-control" name="usuario" placeholder="usuario" value="{{ old('usuario') }}">
                                    <span class="help-block">{{ $errors->first('usuario') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('description') ? ' has-error':'' }}">
                                    <label class="control-label">Descripción</label>
                                    <input type="text" class="form-control" name="description" value="{{ old('description') }}">
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('fecha_desde') ? ' has-error':'' }}">
                                    <label class="control-label">Desde</label>
                                    <input type="date" class="form-control" name="fecha_desde" value="{{ old('fecha_desde') }}">
                                    <span class="help-block">{{ $errors->first('fecha_desde') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('fecha_hasta') ? ' has-error':'' }}">
                                    <label class="control-label">Hasta</label>
                                    <input type="date" class="form-control" name="fecha_hasta" value="{{ old('fecha_hasta') }}">
                                    <span class="help-block">{{ $errors->first('fecha_hasta') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" id="btn_submit" data-loading-text="Consultando logs...">Consultar Logs</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover table-condensed datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Detalle</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->user }}</td>
                                    <td>{{ $log->description }}</td>
                                    <td>{{ $log->created_at->format('d/m/Y h:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form_consulta').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
