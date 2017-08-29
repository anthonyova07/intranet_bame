@extends('layouts.master')

@section('title', 'Extranet - Empresas')

@section('page_title', 'Nueva Extranet Empresa')

@if (can_not_do('extranet_business'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('extranet.business.store') }}" id="form">
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('name') ? ' has-error':'' }}">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="name" value="{{ old('name') }}">
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('address') ? ' has-error':'' }}">
                                    <label class="control-label">Dirección</label>
                                    <input type="text" class="form-control input-sm" name="address" value="{{ old('address') }}">
                                    <span class="help-block">{{ $errors->first('address') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('phone') ? ' has-error':'' }}">
                                    <label class="control-label">Teléfono</label>
                                    <input type="text" class="form-control input-sm" name="phone" value="{{ old('phone') }}">
                                    <span class="help-block">{{ $errors->first('phone') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('extranet.business.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
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
