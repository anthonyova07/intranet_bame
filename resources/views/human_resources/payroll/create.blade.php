@extends('layouts.master')

@section('title', 'Recursos Humanos -> Nómina')

@section('page_title', 'Carga de Nómina')

@if (can_not_do('human_resources_payroll'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Cargar Nómina</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="{{ route('human_resources.payroll.store') }}" id="form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('term') ? ' has-error':'' }}">
                                    <label class="control-label">Archivos <div class="label label-warning"> MAX: 10MB</div></label>
                                    <input type="file" name="payrolls">
                                    <span class="help-block">{{ $errors->first('term') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Cargando archivos...">Cargar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function () {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
