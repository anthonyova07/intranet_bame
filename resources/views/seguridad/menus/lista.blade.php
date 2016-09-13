@extends('layouts.master')

@section('title', 'Seguridad -> Menús')

@section('page_title', 'Menús')

@if (can_not_do('seguridad_menus'))
    @section('contents')
        @include('partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <a class="btn btn-danger btn-sm" href="{{ route('seguridad::menus::nuevo') }}">Nuevo</a>
                <br>
                <br>
                <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|asc'>
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
                                <td>{{ $menu->DESCRIPCION }}</td>
                                <td>{{ $menu->ESTATU == 'A' ? 'Si':'No' }}</td>
                                <td>{{ $menu->WEB == 'S' ? 'Si':'No' }}</td>
                                <td align="center">
                                    <a href="{{ route('seguridad::menus::editar', ['codigo' => $menu->CODIGO]) }}" data-toggle="tooltip" data-placement="top" title="Editar {{ $menu->DESCRIPCION }}" class="naranja"><i class="fa fa-edit fa-fw"></i></a>
                                    <a href="{{ route('seguridad::menus::submenus::lista', ['menu' => $menu->CODIGO]) }}" data-toggle="tooltip" data-placement="top" title="Ver SubMenús de {{ $menu->DESCRIPCION }}"><i class="fa fa-share fa-fw"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
