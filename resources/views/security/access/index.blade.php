@extends('layouts.master')

@section('title', 'Seguridad -> Accesos')

@section('page_title', 'Accesos de Usuarios')

@if (can_not_do('security_access'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('security.access.store') }}" id="form">
                        @if (session()->has('submenus'))
                            <input type="hidden" name="save" value="1">
                        @endif
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('user') ? ' has-error':'' }}">
                                <label class="control-label">Usuario</label>
                                <input type="text" class="form-control input-sm" name="user" placeholder="usuario" value="{{ old('user') }}">
                                <span class="help-block">{{ $errors->first('user') }}</span>
                            </div>
                            <div class="form-group{{ $errors->first('menu') ? ' has-error':'' }}">
                                <label class="control-label">Menú</label>
                                <select class="form-control input-sm" name="menu" id="menu">
                                    <option value="">Selecciona un menú</option>
                                    @foreach ($menus as $menu)
                                        <option value="{{ $menu->men_codigo }}" {{ old('menu') == $menu->men_codigo ? 'selected="selected"':'' }}>{{ $menu->men_descri }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block">{{ $errors->first('menu') }}</span>
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando cambios...">Guardar</button>
                        </div>

                        <div class="col-xs-8">
                            <h3 class="text-center" style="margin-top: 0px;">Accesos</h3>

                            @if (session()->has('submenus'))
                                @foreach (session()->get('submenus') as $submenu)
                                    <div class="col-xs-3">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"{{ session('user_access')->where('acc_submen', $submenu->sub_codigo)->count() ? ' checked' : '' }} name="submenu[]" value="{{ $submenu->sub_codigo }}"> {{ $submenu->sub_descri }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        $('#menu').change(function () {
            $('#submenu').val(0);
            $('#form').submit();
        });
    </script>

@endsection
