@extends('layouts.master')

@section('title', 'Recursos Humanos -> Solicitudes')

@section('page_title', 'Solicitud de Recursos Humanos #' . $human_resource_request->reqnumber)

{{-- @if (can_not_do('human_resource_request'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-xs-2" style="padding: 0 2px;">
                        <a class="btn btn-info btn-xs" href="{{ route('human_resources.request.index', Request::all()) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                    </div>

                    <div class="col-xs-10 text-right" style="padding: 5px 2px;">

                        @if (!can_not_do('human_resource_request_approverh') && $human_resource_request->approvesup && !$human_resource_request->rhuser)
                            {{-- <a class="btn btn-success btn-xs" href="{{ route('human_resources.request.approve', ['request_id' => $human_resource_request->id, 'to_approve' => 1, 'type' => 'rh']) }}"><i class="fa fa-check"></i> Aprobar</a> --}}
                            <a style="color: #5cb85c;" href="{{ route('human_resources.request.approve', ['request_id' => $human_resource_request->id, 'to_approve' => 1, 'type' => 'rh']) }}"><i class="fa fa-check"></i> Aprobar</a>

                            <a
                                href="javascript:void(0)"
                                data-toggle="popover"
                                data-placement="right"
                                data-content="
                                <form action='{{ route('human_resources.request.approve', ['request_id' => $human_resource_request->id, 'to_approve' => 0, 'type' => 'rh']) }}' method='get'>
                                    <div class='row'>
                                        <div class='col-xs-12'>
                                            <div class='form-group'>
                                                <label class='control-label'>Motivo de Rechazo</label>
                                                <textarea rows='10' class='form-control input-sm' name='reason'></textarea>
                                            </div>
                                            {{ str_replace('"', '\'', csrf_field()) }}
                                            {{ str_replace('"', '\'', method_field("PUT")) }}
                                            <input type='submit' class='btn btn-danger btn-xs' value='Rechazar' style='margin-top: 10px;'>
                                        </div>
                                    </div>
                                </form>"
                                style="color: #d82f27;">
                                <i class="fa fa-close"></i> Rechazar</i>
                            </a>

                            {{-- <a class="btn btn-danger btn-xs" href="{{ route('human_resources.request.approve', ['request_id' => $human_resource_request->id, 'to_approve' => 0, 'type' => 'rh']) }}"><i class="fa fa-close"></i> Rechazar</a> --}}
                        @endif

                        @if ($human_resource_request->colsupuser == session()->get('user') && !$human_resource_request->colsupname)
                            <a class="btn btn-success btn-xs" href="{{ route('human_resources.request.approve', ['request_id' => $human_resource_request->id, 'to_approve' => 1, 'type' => 'sup']) }}"><i class="fa fa-check"></i> Aprobar</a>
                            <a class="btn btn-danger btn-xs" href="{{ route('human_resources.request.approve', ['request_id' => $human_resource_request->id, 'to_approve' => 0, 'type' => 'sup']) }}"><i class="fa fa-close"></i> Rechazar</a>
                        @endif

                        @if ($human_resource_request->colsupname)
                            <span style="font-size: 13px;margin: 0 5px;" class="label label-{{ $human_resource_request->approvesup == 1 ? 'success' : 'danger' }}">
                                {{ $human_resource_request->approvesup == 1 ? 'Aprobada por Supervisor' : 'Rechazada por Supervisor' }}
                            </span>
                        @endif

                        @if ($human_resource_request->rhuser)
                            <span style="font-size: 13px;margin: 0 5px;" class="label label-{{ $human_resource_request->approverh == 1 ? 'success' : 'danger' }}">
                                {{ $human_resource_request->approverh == 1 ? 'Aprobada por RRHH' : 'Rechazada por RRHH' }}
                            </span>
                        @endif

                        <a style="font-size: 13px;margin: 3px;" class="label btn-warning" target="__blank" href="">Imprimir</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('human_resources.request.panels.' . strtolower($human_resource_request->reqtype) . '_show', [
        'human_resource_request' => $human_resource_request,
        'statuses' => $statuses,
    ])

@endsection
