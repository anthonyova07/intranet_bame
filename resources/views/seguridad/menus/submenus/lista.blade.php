@extends('layouts.master')

@section('title', 'Seguridad -> SubMenús')

@section('page_title', 'SubMenús')

@if (can_not_do('seguridad_menus'))
    @section('contents')
        @include('partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <a class="btn btn-info" href="{{ route('seguridad::menus::lista') }}"><i class="fa fa-arrow-left"></i> Atras</a>
                <a class="btn btn-danger" href="{{ route('seguridad::menus::submenus::nuevo', ['menu' => request()->menu]) }}">Nuevo</a>
                <br>
                <br>
                <table class="table table-striped table-bordered table-hover table-condensed datatable">
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
                                <td>{{ $submenu->DESCRIPCION }}</td>
                                <td>{{ $submenu->CAPTION }}</td>
                                <td>{{ $submenu->LINK }}</td>
                                <td>{{ $submenu->CODUNI }}</td>
                                <td>{{ $submenu->ESTATU == 'A' ? 'Si':'No' }}</td>
                                <td>{{ $submenu->WEB == 'S' ? 'Si':'No' }}</td>
                                <td align="center">
                                    <a href="{{ route('seguridad::menus::submenus::editar', ['menu' => $submenu->MENU, 'codigo' => $submenu->CODIGO]) }}" data-toggle="tooltip" data-placement="top" title="Editar {{ $submenu->DESCRIPCION }}" class="naranja"><i class="fa fa-edit fa-fw"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
