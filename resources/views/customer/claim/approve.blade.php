@extends('layouts.master')

@section('title', 'Clientes - Reclamaciones')

@section('page_title', 'Comentario de ' . ($to_approve ? 'Aprobación' : 'Rechazo') . ' para la Reclamación')

@if (can_not_do('customer_claim_approve'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('customer.claim.approve', ['claim_id' => $claim->id, 'to_approve' => ($to_approve ? 1 : 0)]) }}" id="form" novalidate>
                        @if ($to_approve == 0)
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group{{ $errors->first('claim_status') ? ' has-error':'' }}">
                                        <label class="control-label">Estatus de la Reclamación</label>
                                        <select class="form-control input-sm" name="claim_status">
                                            <option value="">Seleccione un Estatus para la Reclamación</option>
                                            @foreach ($claim_statuses as $claim_status)
                                                <option value="{{ $claim_status->id }}" {{ old('claim_status') == $claim_status->id ? 'selected':'' }}>{{ $claim_status->description }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">{{ $errors->first('claim_status') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="form-group{{ $errors->first('comment') ? ' has-error':'' }}">
                                    <label class="control-label">Comentario</label>
                                    <input type="text" class="form-control input-sm" name="comment" maxlength="500" value="{{ old('comment') }}">
                                    <span class="help-block">{{ $errors->first('comment') }}</span>
                                </div>
                            </div>
                            @if ($claim->currency == 'US$')
                                <div class="col-xs-2">
                                    <div class="form-group{{ $errors->first('rate_day') ? ' has-error':'' }}">
                                        <label class="control-label">Tasa del Día</label>
                                        <input type="text" class="form-control input-sm" name="rate_day" value="{{ old('rate_day') }}">
                                        <span class="help-block">{{ $errors->first('rate_day') }}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="col-xs-2">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="proceed_credit" {{ old('proceed_credit') ? 'checked' : '' }}> Procede Crédito
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('customer.claim.show', array_merge(['id' => $claim->id], Request::all())) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="{{ $to_approve ? 'Aprobando' : 'Rechazando' }}...">{{ $to_approve ? 'Aprobar' : 'Rechazar' }}</button>
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
