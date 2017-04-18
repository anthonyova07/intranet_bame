@extends('layouts.master')

@section('title', 'Clientes - Reclamaciones')

@if (!$request_type_exists)
    @section('page_title', 'Nueva Solicitud de Recursos Humanos')
@else
    @section('page_title', 'Nueva Solicitud de ' . rh_req_types($type))
@endif

{{-- @if (can_not_do('human_resource_request'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

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
                                <div class="col-xs-10 text-right">
                                    Solicitud de {{ $rh_req_type }}
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
        @include('human_resources.request.forms.' . strtolower($type), [
            'type' => rh_req_types($type)
        ])

        <script type="text/javascript">
            $('#form').submit(function (event) {
                $('#btn_submit').button('loading');
            });
        </script>
    @endif

@endsection
