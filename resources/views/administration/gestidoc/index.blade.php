@extends('layouts.master')

@section('title', 'GestiDoc')

@section('page_title', ($can_not_do ? '' : 'Mantenimiento ') . 'GestiDoc - Administrativo' . ($gestidoc ? ' ('.$gestidoc->name.')' : ''))

@if (can_not_do('adm_gestidoc'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

@if (!$can_not_do)
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="row">
                <div class="col-xs-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Carga de Archivos</h3>
                        </div>
                        <div class="panel-body">
                            <form method="post" action="{{ route('administration.gestidoc.store', ['type' => 'files']) }}" id="form" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group{{ $errors->first('term') ? ' has-error':'' }}">
                                            {{-- <label class="control-label">Archivos <div class="label label-warning"> MAX: 10MB</div></label> --}}
                                            <input type="file" name="files[]" multiple>
                                            <span class="help-block">{{ $errors->first('term') }}</span>
                                        </div>
                                        <input type="hidden" name="folder" value="{{ $folder }}">
                                    </div>
                                    <div class="col-xs-2">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Subiendo archivos...">Subir</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xs-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Nueva Carpeta</h3>
                        </div>
                        <div class="panel-body">
                            <form method="post" action="{{ route('administration.gestidoc.store', ['type' => 'folder']) }}" id="form">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group{{ $errors->first('folder_name') ? ' has-error':'' }}">
                                            {{-- <label class="control-label">Nueva Carpeta</label> --}}
                                            <input type="text" name="folder_name" value="{{ old('folder_name') }}" placeholder="..." class="form-control input-sm">
                                            <span class="help-block">{{ $errors->first('folder_name') }}</span>
                                        </div>
                                        <input type="hidden" name="folder" value="{{ $folder }}">
                                    </div>
                                    <div class="col-xs-2">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Creando carpeta...">Crear</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="panel panel-default">

            <div class="panel-body">
                @if (Request::get('folder'))
                    <a class="btn btn-info btn-xs"
                        href="{{ route('administration.gestidoc.index', ['folder' => ($gestidoc ? $gestidoc->parent_id : null)]) }}"><i class="fa fa-arrow-left"></i> Atras</a>
                    <br>
                    <br>
                @endif
                <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='1|asc'>
                    <thead>
                        <tr>
                            <th style="width: 40px">Tipo</th>
                            <th>Documento</th>
                            <th style="width: 42px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gestidocs as $gesti)
                            <tr>
                                <td style="text-align: center;"><img src="{{ get_file_icon('directory') }}" style="width: 50px;"></td>
                                <td style="vertical-align: middle;">
                                    <a href="{{ route('administration.gestidoc.index', ['folder' => $gesti->id]) }}">{{ $gesti->name }}</a>
                                </td>
                                @if ($can_not_do)
                                    <td></td>
                                @else
                                    <td style="vertical-align: middle;text-align: center;font-size: 20px;">
                                        <a
                                            href="javascript:void(0)"
                                            data-toggle="popover"
                                            data-placement="right"
                                            data-content="
                                            <form action='{{ route("administration.gestidoc.update", ["gestidoc" => $gesti->id, "type" => "rename"]) }}' method='post'>
                                                <div class='row'>
                                                    <div class='col-xs-12'>
                                                        <div class='form-group'>
                                                            <label class='control-label'>Nuevo Nombre</label>
                                                            <input type='text' class='form-control input-sm' value='{{ $gesti->name }}' name='folder_name'>
                                                        </div>
                                                        {{ str_replace('"', '\'', csrf_field()) }}
                                                        {{ str_replace('"', '\'', method_field("PUT")) }}
                                                        <input type='submit' class='btn btn-danger btn-xs' value='Guardar' style='margin-top: 10px;'>
                                                    </div>
                                                </div>
                                            </form>"
                                            style="color: orange;">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a
                                            href="javascript:void(0)"
                                            data-toggle="popover"
                                            data-placement="right"
                                            data-content="
                                            <form action='{{ route("administration.gestidoc.update", ["gestidoc" => $gesti->id, "type" => "access"]) }}' method='post'>
                                                <div class='row'>
                                                    <div class='col-xs-12'>
                                                        <div class='form-group'>
                                                            <label class='control-label'>Usuarios con Acceso a Esta Carpeta</label>
                                                            <textarea rows='15' cols='24' class='form-control input-sm' name='usrsaccess'>{{ $gesti->usrsaccess }}</textarea>
                                                        </div>
                                                        {{ str_replace('"', '\'', csrf_field()) }}
                                                        {{ str_replace('"', '\'', method_field("PUT")) }}
                                                        <input type='submit' class='btn btn-danger btn-xs' value='Guardar' style='margin-top: 10px;'>
                                                    </div>
                                                </div>
                                            </form>"
                                            style="color: green;">
                                            <i class="fa fa-plus-square"></i>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        @foreach ($files as $file)
                            <tr>
                                <td style="text-align: center;"><img src="{{ get_file_icon($file->type) }}" style="width: 50px;"></td>
                                <td style="vertical-align: middle;">
                                    {{ $file->name }}
                                </td>
                                <td style="vertical-align: middle;text-align: center;font-size: 20px;">
                                    <a
                                        href="{{ $file->url }}"
                                        target="_blank"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Descargar {{ $file->name }}">
                                        <i class="fa fa-download fa-fw"></i>
                                    </a>
                                    @if (!$can_not_do)
                                        <a
                                            onclick="cancel('{{ $file->name }}', this)"
                                            href="javascript:void(0)"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Eliminar {{ $file->name }}"
                                            class="rojo link_delete">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </a>
                                        <form
                                            action="{{ route('administration.gestidoc.destroy', ['gestidoc' => $gestidoc->id, 'file' => $file->file]) }}"
                                            method="post" id="form_eliminar_{{ $file->name }}">
                                            <input type="hidden" name="folder" value="{{ $gestidoc->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $('#form').submit(function (event) {
        $('#btn_submit').button('loading');
    });

    function cancel(id, el)
    {
        res = confirm('Realmente desea eliminar este archivo?');

        if (!res) {
            event.preventDefault();
            return;
        }

        $(el).remove();

        $('#form_eliminar_' + id).submit();
    }
</script>
@endsection
