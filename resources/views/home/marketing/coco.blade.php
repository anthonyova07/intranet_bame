@extends('layouts.master')

@section('title', 'Rompete el Coco')

@section('page_title', 'Rompete el Coco - Idea')

@section('contents')

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">

                    @if ($coco->get()->active)

                        <form method="post" action="{{ route('coco') }}" id="form">
                            @if (!session()->has('user'))
                                <div class="form-group{{ $errors->first('name_last_name') ? ' has-error':'' }}">
                                    <label class="control-label">Nombre y Apellido</label>
                                    <input type="text" class="form-control input-sm" name="name_last_name" value="{{ old('name_last_name') }}">
                                    <span class="help-block">{{ $errors->first('name_last_name') }}</span>
                                </div>
                                <div class="form-group{{ $errors->first('mail') ? ' has-error':'' }}">
                                    <label class="control-label">Correo</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control input-sm" name="mail" value="{{ str_replace('@bancamerica.com.do', '', old('mail')) }}">
                                        <span class="input-group-addon">@bancamerica.com.do</span>
                                    </div>
                                    <span class="help-block">{{ $errors->first('mail') }}</span>
                                </div>
                            @endif
                            <div class="form-group{{ $errors->first('idea') ? ' has-error':'' }}">
                                <label class="control-label">Idea</label>
                                <textarea class="form-control input-sm" name="idea" rows="5"></textarea>
                                <span class="help-block">{{ $errors->first('idea') }}</span>
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Enviando idea...">Enviar</button>
                        </form>

                    @else

                        <div class="panel-body text-center">
                            <label class="control-label text-center label label-danger" style="font-size: 24px;">El concurso se encuentra inhabilitado.</label>
                        </div>

                    @endif

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
