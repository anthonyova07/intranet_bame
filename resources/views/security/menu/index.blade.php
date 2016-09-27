@extends('layouts.master')

@section('title', 'Seguridad -> Menús')

@section('page_title', 'Menús')

@if (can_not_do('security_menu'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <a class="btn btn-danger btn-xs" href="{{ route('security.menu.create') }}">Nuevo</a>
                <br>
                <br>
                <table class="table table-striped table-bordered table-hover table-condensed" order-by='0|asc'>
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Activo</th>
                            <th>WEB</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                            <tr>
                                <td>{{ $menu->men_descri }}</td>
                                <td>{{ $menu->men_estatu == 'A' ? 'Si':'No' }}</td>
                                <td>{{ $menu->men_web == 'S' ? 'Si':'No' }}</td>
                                <td align="center">
                                    <a
                                        href="{{ route('security.menu.edit', ['id' => $menu->men_codigo]) }}"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Editar {{ $menu->men_descri }}"
                                        class="naranja">
                                        <i class="fa fa-edit fa-fw"></i>
                                    </a>
                                    <a
                                        onclick="document.getElementById('form_eliminar_{{ $menu->men_codigo }}').submit();"
                                        href="javascript:void(0)"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Eliminar {{ $menu->men_descri }}"
                                        class="rojo link_delete">
                                        <i class="fa fa-close fa-fw"></i>
                                    </a>
                                    <a
                                        href="{{ route('security.menu.{menu}.submenu.index', ['menu' => $menu->men_codigo]) }}"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Ver SubMenús de {{ $menu->men_descri }}">
                                        <i class="fa fa-share fa-fw"></i>
                                    </a>
                                    <form
                                        action="{{ route('security.menu.destroy', ['id' => $menu->men_codigo]) }}"
                                        method="post" id="form_eliminar_{{ $menu->men_codigo }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $menus->links() }}
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
