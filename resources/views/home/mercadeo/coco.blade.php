@extends('layouts.master')

@section('title', 'Rompete el Coco')

@section('page_title', 'Rompete el Coco - Idea')

@section('contents')

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">

                    @if ($coco->get()->active)

                        <form method="post" action="#" id="form_encarte">
                            <div class="form-group{{ $errors->first('nombre') ? ' has-error':'' }}">
                                <label class="control-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}">
                                <span class="help-block">{{ $errors->first('nombre') }}</span>
                            </div>
                            <div class="form-group{{ $errors->first('correo') ? ' has-error':'' }}">
                                <label class="control-label">Correo</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="correo">
                                    <span class="input-group-addon">@bancamerica.com.do</span>
                                </div>
                                <span class="help-block">{{ $errors->first('correo') }}</span>
                            </div>
                            <div class="form-group{{ $errors->first('idea') ? ' has-error':'' }}">
                                <label class="control-label">Idea</label>
                                <textarea class="form-control" name="idea" rows="5"></textarea>
                                <span class="help-block">{{ $errors->first('idea') }}</span>
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" id="btn_submit" data-loading-text="Enviando idea...">Enviar</button>
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
        $('#form_encarte').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
