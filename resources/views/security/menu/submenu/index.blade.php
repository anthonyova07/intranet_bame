@extends('layouts.master')

@section('title', 'Seguridad -> SubMenús')

@section('page_title', 'SubMenús')

@if (can_not_do('security_menu'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <a class="btn btn-info btn-xs" href="{{ route('security.menu.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                <a class="btn btn-danger btn-xs" href="{{ route('security.menu.{menu}.submenu.create', ['menu' => request()->menu]) }}">Nuevo</a>
                <br>
                <br>
                <table class="table table-striped table-bordered table-hover table-condensed" order-by='0|asc'>
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Título</th>
                            <th>Link</th>
                            <th>Cód Único</th>
                            <th>Activo</th>
                            <th>Web</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($submenus as $submenu)
                            <tr>
                                <td>{{ $submenu->sub_descri }}</td>
                                <td>{{ $submenu->sub_caption }}</td>
                                <td>{{ $submenu->sub_link }}</td>
                                <td>{{ $submenu->sub_coduni }}</td>
                                <td>{{ $submenu->sub_estatu == 'A' ? 'Si':'No' }}</td>
                                <td>{{ $submenu->sub_web == 'S' ? 'Si':'No' }}</td>
                                <td align="center">
                                    <a
                                        href="{{ route('security.menu.{menu}.submenu.edit', ['menu' => $submenu->sub_codmen, 'id' => $submenu->sub_codigo]) }}"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Editar {{ $submenu->sub_descri }}"
                                        class="naranja">
                                        <i class="fa fa-edit fa-fw"></i>
                                    </a>
                                    <a
                                        onclick="document.getElementById('form_eliminar_{{ $submenu->sub_codigo }}').submit();"
                                        href="javascript:void(0)"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Eliminar {{ $submenu->sub_descri }}"
                                        class="rojo link_delete">
                                        <i class="fa fa-close fa-fw"></i>
                                    </a>
                                    <form
                                        action="{{ route('security.menu.{menu}.submenu.destroy', ['menu' => $submenu->sub_codmen, 'id' => $submenu->sub_codigo]) }}"
                                        method="post" id="form_eliminar_{{ $submenu->sub_codigo }}">
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

    <script>
        $('.link_delete').click(function (event) {
            res = confirm('Realmente desea Eliminar este menú?');

            if (!res) {
                event.preventDefault();
                return;
            }

            $(this).remove();
        });
    </script>

@endsection
