@extends('layouts.master')

@section('title', 'Encartes')

@section('page_title', 'Generación de Encartes')

@if (can_not_do('op_tdc_encartes'))
    @section('contents')
        @include('partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-xs-4">
                    <form method="post" action="{{ route('operaciones::tdc::encartes') }}" id="form_encarte">
                        <div class="form-group{{ $errors->first('identificacion') ? ' has-error':'' }}">
                            <label class="control-label">Identificación</label>
                            <input type="text" class="form-control" name="identificacion" placeholder="Cédula/Pasaporte" value="{{ old('identificacion') }}">
                            <span class="help-block">{{ $errors->first('identificacion') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('tarjeta') ? ' has-error':'' }}">
                            <label class="control-label"># TDC</label>
                            <input type="text" class="form-control" name="tarjeta" placeholder="0000-0000-0000-0000" value="{{ old('tarjeta') }}">
                            <span class="help-block">{{ $errors->first('tarjeta') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('fecha') ? ' has-error':'' }}">
                            <label class="control-label">Fecha</label>
                            <input type="text" class="form-control" name="fecha" placeholder="yyyy-mm-dd" value="{{ old('fecha') }}">
                            <span class="help-block">{{ $errors->first('fecha') }}</span>
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger" id="btn_submit" data-loading-text="Generando encartes...">Generar PDFs <span class="badge" data-toggle="tooltip" data-placement="bottom" title="Encartes Pendientes">{{ $cantidad }}</span></button>
                        {{-- <a href="http://192.168.0.100/intranet/pdfs/encartes/" target="__blank" class="btn btn-info pull-right">Ver encartes</a> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form_encarte').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
