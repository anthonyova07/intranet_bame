<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Carga de Archivos</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="{{ route($department . '.gestidoc.store') }}" id="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="form-group{{ $errors->first('term') ? ' has-error':'' }}">
                                <label class="control-label">Archivos <div class="label label-warning"> MAX: 10MB</div></label>
                                <input type="file" name="files[]" multiple>
                                <span class="help-block">{{ $errors->first('term') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('folder') ? ' has-error':'' }}">
                                <label class="control-label">Carpeta <u>Separador: <b>\</b></u></label>
                                <input type="text" name="folder" value="{{ Request::get('folder') }}" class="form-control input-sm">
                                <span class="help-block">{{ $errors->first('folder') }}</span>
                            </div>
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
</div>

<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="panel panel-default">

            <div class="panel-body">
                @if (Request::get('folder'))
                    <a class="btn btn-info btn-xs"
                        href="{{ route($department . '.gestidoc.index', ['folder' => gesti_doc_back_folder(Request::get('folder'))]) }}"><i class="fa fa-arrow-left"></i> Atras</a>
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
                        @foreach ($files as $file)
                            <tr>
                                <td style="text-align: center;"><img src="{{ get_file_icon($file->type) }}" style="width: 50px;"></td>
                                <td style="vertical-align: middle;">
                                    @if ($file->type == 'directory')
                                        <a href="{{ $file->url }}">{{ $file->name }}</a>
                                    @else
                                        {{ str_replace('_', ' ', $file->name) }}
                                    @endif
                                </td>
                                <td style="vertical-align: middle;text-align: center;font-size: 20px;">
                                    @if ($file->type != 'directory')
                                        <a
                                            href="{{ $file->url }}"
                                            target="_blank"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Descargar {{ str_replace('_', ' ', $file->name) }}">
                                            <i class="fa fa-download fa-fw"></i>
                                        </a>
                                        <a
                                            onclick="cancel('{{ $file->name }}', this)"
                                            href="javascript:void(0)"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Eliminar {{ str_replace('_', ' ', $file->name) }}"
                                            class="rojo link_delete">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </a>
                                        <form
                                            action="{{ route($department . '.gestidoc.destroy', ['file' => $file->file]) }}"
                                            method="post" id="form_eliminar_{{ $file->name }}">
                                            <input type="hidden" name="folder" value="{{ Request::get('folder') }}">
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
