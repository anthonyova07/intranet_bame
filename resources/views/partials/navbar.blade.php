<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ route('home') }}" style="padding-top: 0px;">
            <img src="{{ route('home') }}/images/logo.jpg" style="width: 200px;margin-left: 8px;">
        </a>
        {{-- <a class="navbar-brand" href="{{ route('home') }}" style="padding-left: 0px; font-size: 25px;">Bancamérica - INTRANET</a> --}}
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        @if (session()->has('usuario'))
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-alerts" title="Haga clic para eliminar notificación" data-toggle="tooltip" data-placement="left">
                    @if ($notificaciones)
                        @foreach ($notificaciones->sortByDesc('creado') as $notificacion)
                            <li id="{{ $notificacion->id }}">
                                <a href="javascript:void(0)" onclick="eliminar_notificacion('{{ $notificacion->id }}')">
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i> {{ $notificacion->texto }}
                                        <span class="pull-right text-muted small">{{ $notificacion->creado }}</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider" id="{{ $notificacion->id }}_divider"></li>
                        @endforeach
                    @endif
                    <li>
                        <a class="text-center" href="javascript:void(0)">
                            <strong>Alertas de {{ session('usuario') }}</strong>
                        </a>
                    </li>
                </ul>
                <!-- /.dropdown-alerts -->
            </li>
        @endif
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                @if (session()->has('usuario'))
                    <li>
                        <a href="#"><i class="fa fa-user fa-fw"></i> {{ session()->get('usuario') }}</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('auth.logout') }}"><i class="fa fa-sign-out fa-fw"></i> Cerrar sesión</a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('auth.login') }}"><i class="fa fa-sign-in fa-fw"></i> Iniciar sesión</a>
                    </li>
                @endif
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                {{-- <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    <!-- /input-group -->
                </li> --}}
                <li>
                    <a href="{{ route('home') }}"><i class="fa fa-home fa-fw"></i> Inicio</a>
                </li>
                @if (session()->has('menus'))
                    @foreach (session()->get('menus') as $menu)
                        <li>
                            <a href="#">
                                <i class="fa fa-lock fa-fw"></i>
                                {{ $menu->DESCRIPCION }}
                                <span class="fa arrow"></span>
                            </a>
                            @if ($menu->submenus->count())
                                <ul class="nav nav-second-level">
                                    @foreach ($menu->submenus as $submenu)
                                        <li>
                                            <a href="{{ route($submenu->LINK) }}">
                                                <i class="fa fa-unlock-alt fa-fw"></i>
                                                {{ $submenu->DESCRIPCION }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
