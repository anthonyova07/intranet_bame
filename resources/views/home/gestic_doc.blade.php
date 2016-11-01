@extends('layouts.master')

@section('title', 'Gestic Doc')

@section('page_title', 'Gestic Doc - ' . get_department_name($department))

@section('contents')

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">

                <div class="panel-body">
                    @if (Request::get('folder'))
                        <a class="btn btn-info btn-xs"
                            href="{{ route('gesticdoc.' . $department, ['folder' => gesti_doc_back_folder(Request::get('folder'))]) }}"><i class="fa fa-arrow-left"></i> Atras</a>
                        <br>
                        <br>
                    @endif
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='1|asc'>
                        <thead>
                            <tr>
                                <th style="width: 40px">Tipo</th>
                                <th>Documento</th>
                                <th style="width: 40px"></th>
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
                                    <td style="vertical-align: middle;text-align: center;font-size: 35px;">
                                        @if ($file->type != 'directory')
                                            <a
                                                href="{{ $file->url }}"
                                                target="_blank"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Descargar {{ str_replace('_', ' ', $file->name) }}">
                                                <i class="fa fa-download fa-fw"></i>
                                            </a>
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
    </script>

@endsection
