@extends('layouts.master')

@section('title', 'Seguridad -> Logs')

@section('page_title', 'Logs del Sistema')

@if (can_not_do('security_log'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Filtros de Búsqueda</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="{{ route('security.log.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('id') ? ' has-error':'' }}">
                                    <label class="control-label">ID</label>
                                    <input type="text" class="form-control input-sm" name="id" placeholder="###" value="{{ old('id') }}">
                                    <span class="help-block">{{ $errors->first('id') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('user') ? ' has-error':'' }}">
                                    <label class="control-label">Usuario</label>
                                    <input type="text" class="form-control input-sm" name="user" placeholder="usuario" value="{{ old('user') }}">
                                    <span class="help-block">{{ $errors->first('user') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('description') ? ' has-error':'' }}">
                                    <label class="control-label">Descripción</label>
                                    <input type="text" class="form-control input-sm" name="description" placeholder="texto de busqueda..." value="{{ old('description') }}">
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('date_from') ? ' has-error':'' }}">
                                    <label class="control-label">Desde</label>
                                    <input type="date" class="form-control input-sm" name="date_from" value="{{ old('date_from') }}">
                                    <span class="help-block">{{ $errors->first('date_from') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('date_to') ? ' has-error':'' }}">
                                    <label class="control-label">Hasta</label>
                                    <input type="date" class="form-control input-sm" name="date_to" value="{{ old('date_to') }}">
                                    <span class="help-block">{{ $errors->first('date_to') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Consultando logs...">Consultar Logs</button>
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
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='3|desc'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Detalle</th>
                                <th style="width: 130px;">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->user }}</td>
                                    <td>{{ $log->description }}</td>
                                    <td>{{ $log->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $logs->appends(Request::all())->links() }}

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
