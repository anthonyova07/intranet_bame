@extends('layouts.master')

@section('title', 'Clientes - Reclamaciones')

@section('page_title', 'Comentario para Cerrar/Cambiar Estado de la Reclamación')

@if (can_not_do('customer_claim_close'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('customer.claim.close', ['claim_id' => $claim->id]) }}" id="form" novalidate>

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

                        <div class="row">
                            <div class="col-xs-8">
                                <div class="form-group{{ $errors->first('comment') ? ' has-error':'' }}">
                                    <label class="control-label">Comentario/Solución</label>
                                    <input type="text" class="form-control input-sm" name="comment" maxlength="500" value="{{ old('comment') }}">
                                    <span class="help-block">{{ $errors->first('comment') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('claim_result') ? ' has-error':'' }}">
                                    <label class="control-label">Resultado</label>
                                    <select class="form-control input-sm" name="claim_result" data-toggle="tooltip" title="Colocar (Pendiente) para cambiar de estado">
                                        @foreach (get_claim_results() as $key => $claim_result)
                                            <option value="{{ $key }}" {{ old('claim_result') == $key ? 'selected':'' }}>{{ $claim_result }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('claim_result') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('customer.claim.show', array_merge(['id' => $claim->id], Request::all())) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                        <button data-toggle="tooltip" title="Cerrar o Cambiar de Estado" type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Cerrar...">Cerrar / Cambiar</button>
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
