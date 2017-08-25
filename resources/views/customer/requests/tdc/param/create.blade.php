@extends('layouts.master')

@section('title', 'Reclamaciones - ' . get_request_tdc_param($type, false))

@section('page_title', 'Nuevo ' . get_request_tdc_param($type, false))

{{-- @if (can_not_do('customer_claim_param'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <div class="row">

        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('customer.request.tdc.{type}.param.store', ['type' => $type]) }}" id="form" novalidate>
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="form-group{{ $errors->first('description') ? ' has-error':'' }}">
                                    <label class="control-label">Descripción</label>
                                    <input type="text" class="form-control input-sm" name="description" value="{{ old('description') }}">
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="is_black" {{ old('is_black') ? 'checked' : '' }}> Lista Negra
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('customer.request.tdc.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $('#form').submit(function (vacant) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
