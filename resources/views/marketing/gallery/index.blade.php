@extends('layouts.master')

@section('title', 'Galería de Fotos')

@section('page_title', 'Mantenimiento de Álbum de Fotos')

@if (can_not_do('marketing_gallery'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a class="btn btn-danger btn-xs" href="{{ route('marketing.gallery.create') }}">Nuevo Álbum</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th style="width: 85px;">Portada</th>
                                <th>Álbum</th>
                                <th style="width: 40px;">Fecha</th>
                                <th style="width: 50px;">Estatus</th>
                                <th style="width: 40px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($galleries as $gallery)
                                <tr>
                                    <td><img style="width: 100px;" alt="No encontrada" src="{{ route('home') . '/files/gallery/' . $gallery->id . '/' . $gallery->image }}"></td>
                                    <td>{{ $gallery->name }}</td>
                                    <td>{{ $gallery->galdate->format('Y-m-d') }}</td>
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
                                        <a
                                            onclick="cancel('{{ $gallery->id }}', this)"
                                            href="javascript:void(0)"
                                            data-toggle="tooltip"
                                            data-placement="left"
                                            title="Eliminar {{ $gallery->name }}"
                                            class="rojo link_delete">
                                            <i class="fa fa-close fa-fw"></i>
                                        </a>
                                        <form
                                            action="{{ route('marketing.gallery.destroy', ['id' => $gallery->id]) }}"
                                            method="post" id="form_eliminar_{{ $gallery->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
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
            res = confirm('Realmente desea eliminar este álbum?\n\nNota: Todas las imágenes asociadas serán eliminadas permanentemente.');

            if (!res) {
                event.preventDefault();
                return;
            }

            $(el).remove();

            $('#form_eliminar_' + id).submit();
        }
    </script>

@endsection
