@extends('layouts.master')

@section('title', 'Galería de Fotos')

@section('page_title', 'Mantenimiento de Galería de Fotos')

{{-- @if (can_not_do('process_gestidoc'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a class="btn btn-danger btn-xs" href="{{ route('marketing.gallery.create') }}">Nueva Galería</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|asc'>
                        <thead>
                            <tr>
                                <th>Galería</th>
                                <th style="width: 50px;">Estatus</th>
                                <th style="width: 25px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($galleries as $gallery)
                                <tr>
                                    <td>{{ $gallery->name }}</td>
                                    <td>
                                        <label style="font-size: 12px;letter-spacing: 1px;" class="label label-{{ $gallery->is_active ? 'success' : 'danger' }}">{{ $gallery->is_active ? 'Activa' : 'Inactiva' }}</label>
                                    </td>
                                    <td align="center">
                                        <a
                                            href="{{ route('marketing.gallery.edit', ['gallery' => $gallery->id]) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Editar"
                                            class="naranja">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                        <a
                                            href="{{ route('marketing.gallery.show', ['gallery' => $gallery->id]) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Cargar/Ver Imagenes">
                                            <i class="fa fa-share fa-fw"></i>
                                        </a>
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
