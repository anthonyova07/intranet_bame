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
                        <div class="row">
                            <div class="col-xs-9">
                                <div class="form-group{{ $errors->first('comment') ? ' has-error':'' }}">
                                    <label class="control-label">Comentario</label>
                                    <input type="text" class="form-control input-sm" name="comment" maxlength="500" value="{{ old('comment') }}">
                                    <span class="help-block">{{ $errors->first('comment') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
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
