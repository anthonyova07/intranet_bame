@extends('layouts.master')

@section('title', 'Clientes - Mantenimiento Direcciones')

@section('page_title', 'Mantenimientos de Direcciones IBS e ITC')

@if (can_not_do('customer_maintenance_address'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a class="btn btn-danger btn-xs btn-block" style="padding: 24px;font-size: 40px;" href="{{ route('customer.maintenance.create') }}">Nuevo Mantenimiento</a>
                </div>
            </div>
        </div>
    </div>

    @if (!can_not_do('customer_approvals_address'))

        <div class="row" style="border-bottom: 1px solid #777;border-top: 1px solid #777;margin: 8px 0 25px 0;border-width: 5px;">
            <h1 style="margin: 0;text-align: center;">Aprobaciones</h1>
        </div>

        <div class="row">

            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Búscar Aprobación</h3>
                    </div>
                    <div class="panel-body">
                        <form method="get" action="{{ route('customer.maintenance.index') }}" id="form">
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="form-group{{ $errors->first('term') ? ' has-error':'' }}">
                                        <label class="control-label">Término</label>
                                        <input type="text" class="form-control input-sm" name="term" placeholder="término de busqueda..." value="{{ request('term') }}">
                                        <span class="help-block">{{ $errors->first('term') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group{{ $errors->first('date_from') ? ' has-error':'' }}">
                                        <label class="control-label">Desde</label>
                                        <input type="date" class="form-control input-sm" name="date_from" value="{{ request('date_from') }}">
                                        <span class="help-block">{{ $errors->first('date_from') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group{{ $errors->first('date_to') ? ' has-error':'' }}">
                                        <label class="control-label">Hasta</label>
                                        <input type="date" class="form-control input-sm" name="date_to" value="{{ request('date_to') }}">
                                        <span class="help-block">{{ $errors->first('date_to') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="checkbox">
                                        <label style="margin-top: 18px;">
                                            <input type="checkbox" name="pending_approval"{{ request('pending_approval') ? ' checked':'' }}> Pendiente de Aprobación
                                        </label>
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

            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <a style="font-size: 13px;margin-left: 10px;" class="label btn-primary pull-right" id="approve_maintenances" href="" url="{{ route('customer.maintenance.approve') }}">Aprobar</a>

                        <a style="font-size: 13px;margin-bottom: 8px;" download class="label btn-success pull-right" target="__blank" href="{{ route('customer.maintenance.create', Request::except(['term', 'page'])) }}">Exportar Excel</a>

                        <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                            <thead>
                                <tr>
                                    <th># Cliente</th>
                                    <th># Identificación</th>
                                    <th>Core</th>
                                    <th>Aprobado</th>
                                    <th>Aprobado por</th>
                                    <th>Aprobado el</th>
                                    <th style="width: 112px;">Fecha Creación</th>
                                    <th style="width: 112px;">Creado por</th>
                                    <th style="width: 52px">Aprobación</th>
                                    <th class="text-center" style="width: 75px">
                                        <input type="checkbox" data-toggle="tooltip" title="Seleccionar Todo" name="check_all" value="" id="check_all">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($maintenances as $m)
                                    <tr>
                                        <td>{{ $m->clinumber }}</td>
                                        <td>{{ $m->cliident }}</td>
                                        <td>{{ strtoupper($m->typecore) }}</td>
                                        <td>{{ $m->isapprov ? 'Si' : 'No' }}</td>
                                        <td>{{ $m->approvname }}</td>
                                        <td>{{ $m->isapprov ? date_create($m->approvdate)->format('d/m/Y H:i:s') : '' }}</td>
                                        <td>{{ date_create($m->created_at)->format('d/m/Y H:i:s') }}</td>
                                        <td>{{ $m->createname }}</td>
                                        <td align="center">
                                            @if (!$m->isapprov)
                                                <a
                                                    href="{{ route('customer.maintenance.approve', array_merge(['to_approver' => 1, 'ids' => $m->id], Request::only('page'))) }}"
                                                    class="verde link_approv"
                                                    onclick="approve(this)"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Aprobar">
                                                    <i class="fa fa-check fa-fw"></i>
                                                </a>
                                                <a
                                                    href="{{ route('customer.maintenance.print', $m->id) }}"
                                                    class=""
                                                    style="color: #ffa500;"
                                                    onclick="approve(this)"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    target="__blank"
                                                    title="Imprimir">
                                                    <i class="fa fa-print fa-fw"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td align="center">
                                            @if (!$m->isapprov)
                                                <input type="checkbox" class="check_approve" data-toggle="tooltip" title="Marcar para aprobar" name="requests[]" value="{{ $m->id }}">
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $maintenances->appends(request()->all())->links() }}
                    </div>
                </div>
            </div>

        </div>
    @endif

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        $('#approve_maintenances').click(function (e) {
            var ids = '?to_approver=1&ids=';
            var count = 0;

            $('.check_approve').each(function (index, check) {
                if ($(check).is(':checked')) {
                    ids += $(check).val() + ',';
                    count++;
                }
            });

            if (!count) {
                alert('No ha seleccionado ningún mantenimiento para aprobar.');
                return false;
            }

            $(this).attr('href', $(this).attr('url') + ids);
        });

        var check_all = $('#check_all');

        check_all.change(function () {
            $('.check_approve').each(function (index, check) {
                $(check).prop('checked', check_all.is(':checked'));
            });
        });
    </script>

@endsection
