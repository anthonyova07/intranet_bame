@extends('layouts.master')

@section('title', 'Mercadeo - Empleados - Vacaciones')

@section('page_title', 'Vacaciones')

@if (can_not_do('human_resources_employee_vacations'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('human_resources.employee.vacation.store') }}" id="form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('startyear') ? ' has-error':'' }}">
                                    <label class="control-label">Año Desde a Generar</label>
                                    <input type="text" class="form-control input-sm" name="startyear" value="{{ old('startyear') }}">
                                    <span class="help-block">{{ $errors->first('startyear') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('endyear') ? ' has-error':'' }}">
                                    <label class="control-label">Año Hasta a Generar</label>
                                    <input type="text" class="form-control input-sm" name="endyear" value="{{ old('endyear') }}">
                                    <span class="help-block">{{ $errors->first('endyear') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-block btn-xs" id="btn_submit" data-loading-text="Generando...">Generar</button>
                    </form>
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
