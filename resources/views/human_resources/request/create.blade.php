@extends('layouts.master')

@section('title', 'Recursos Humanos -> Solicitudes')

@if (!$request_type_exists)
    @section('page_title', 'Nueva Solicitud de Recursos Humanos')
@else
    @section('page_title', 'Nueva ' . rh_req_types($type))
@endif

@if (request('access') == 'admin')
    @if (can_not_do('human_resource_request'))
        @section('contents')
            @include('layouts.partials.access_denied')
        @endsection
    @endif
@endif

@section('contents')

    @if (!$request_type_exists)
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
                <div class="panel panel-default">
                  <div class="panel-body">
                      <input type="text" id="search_field" placeholder="Busqueda rapida de solicitudes" class="form-control input-lg" autofocus>
                  </div>
                </div>
            </div>
        </div>

        <div class="row" id="reports">
            @foreach (rh_req_types() as $key => $rh_req_type)
                <div class="col-xs-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-2">
                                    <i class="fa fa-wpforms fa-4x"></i>
                                </div>
                                <div class="col-xs-10 text-right" style="padding-right: 4px;">
                                    {{ $rh_req_type }}
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('human_resources.request.create', ['type' => $key]) }}">
                            <div class="panel-footer" style="padding: 2px 86px;">
                                <span class="pull-left">Crear</span>
                                <span class="pull-right"><i class="fa fa-plus"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <script type="text/javascript">
            @include('layouts.functions_js.busqueda_rapida');
        </script>
    @else
        @include('human_resources.request.panels.' . strtolower($type), [
            'type' => $type,
            'type_desc' => rh_req_types($type),
            'employee_date' => $employee_date,
        ])

        <script type="text/javascript">
            $('#form').submit(function (event) {
                $('#btn_submit').button('loading');
            });

            var radio_dialibre = $('input[type=radio][code=DIALIBRE]');
            var radio_cumple = $('input[type=radio][code=CUMPLE]');
            var one_day = $('input[type=radio][value=one_day]');

            radio_dialibre.change(function () {
                one_day.prop('checked', true);
                one_day.change();
            });

            radio_cumple.change(function () {
                one_day.prop('checked', true);
                one_day.change();
            });
        </script>
    @endif

@endsection
