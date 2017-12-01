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

    <ul class="nav navbar-top-links navbar-right text-right">
        <li class="pull-left" style="margin-left: -41px;">
            <img src="{{ route('home') }}/images/navesquina.svg" style="width: 41px;">
        </li>
        @if (session()->has('user'))
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-alerts" title="Haga clic para eliminar notificación" data-toggle="tooltip" data-placement="left">
                    @if ($notifications)
                        @foreach ($notifications->sortByDesc('creado') as $notification)
                            <li id="{{ $notification->id }}">
                                <a href="javascript:void(0)" onclick="delete_notification('{{ $notification->id }}')">
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i> {{ $notification->texto }}
                                        <span class="pull-right text-muted small">{{ $notification->creado }}</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider" id="{{ $notification->id }}_divider"></li>
                        @endforeach
                    @endif
                    <li>
                        <a class="text-center" href="javascript:void(0)">
                            <strong>Alertas de {{ session()->get('user') }}</strong>
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
                @if (session()->has('user'))
                    <li>
                        <a href="#"><i class="fa fa-user fa-fw"></i> {{ session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName() }}</a>
                    </li>
                    <li>
                        <a href="{{ route('events.accompanist.index') }}"><i class="fa fa-group fa-fw"></i> Acompañantes</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('human_resources.payroll.my') }}"><i class="fa fa-money fa-fw"></i> Mis Nóminas</a>
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
                <li>
                    <a href="https://bancaonline.bancamerica.com.do/onlinebanking" target="_blank">
                    <img src="{{ route('home') }}/images/iconobame.png" style="width: 20px;" alt="">
                    Internet Banking
                    </a>
                </li>
                <li>
                    <a href="{{ route('home.gallery') }}">
                        <i class="fa fa-image fa-fw"></i>
                        Galería de Fotos
                    </a>
                </li>
                @if (url_closing_cost() != null)
                    <li>
                        <a href="{{ url_closing_cost() }}" target="_blank">
                            <i class="fa fa-bar-chart fa-fw"></i>
                            Gastos de Cierre
                        </a>
                    </li>
                @endif
                <li>
                    <a href="#">
                        <i class="fa fa-download fa-fw"></i>
                        GestiDoc
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level animated zoomInLeft" style="animation-duration: 0.5s;">
                        <li>
                            <a href="{{ route('gestidoc.compliance') }}">
                                <i class="fa fa-files-o fa-fw"></i>
                                Cumplimiento
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('gestidoc.marketing') }}">
                                <i class="fa fa-files-o fa-fw"></i>
                                Mercadeo
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('gestidoc.process') }}">
                                <i class="fa fa-files-o fa-fw"></i>
                                Procesos
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('gestidoc.human_resources') }}">
                                <i class="fa fa-files-o fa-fw"></i>
                                Recursos Humanos
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('home.news_list') }}">
                        <i class="fa fa-newspaper-o fa-fw"></i>
                        Noticias
                    </a>
                </li>
                <li>
                    <a href="{{ route('home.faqs') }}">
                        <i class="fa fa-question fa-fw"></i>
                        Preguntas Frecuentes
                    </a>
                </li>
                <li style="border-bottom: 5px solid #e7e7e7;">
                    <a href="{{ route('home.rates') }}">
                        <i class="fa fa-money fa-fw"></i>
                        Tasas de Interés
                    </a>
                </li>
                @if (session()->has('menus'))
                    <li style="border-bottom: 5px solid #e7e7e7;">
                        <a href="#">
                            <i class="fa fa-universal-access fa-fw"></i>
                            Empleado Bancamérica
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level animated zoomInLeft" style="animation-duration: 0.5s;">
                            <li>
                                <a class="effect" href="{{ route('human_resources.payroll.my') }}">
                                    <i class="fa fa-money fa-fw"></i>
                                    Mis Nóminas
                                </a>
                            </li>
                            <li>
                                <a class="effect" href="{{ route('human_resources.request.index') }}">
                                    <i class="fa fa-wpforms fa-fw"></i>
                                    Consulta Solicitudes
                                </a>
                            </li>
                            <li>
                                <a href="#" class="no-effect">
                                    <i class="fa fa-plus fa-fw"></i>
                                    Nuevas Solicitud
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-third-level animated zoomInLeft" style="animation-duration: 0.5s;">
                                    @foreach (rh_req_types()->sort() as $key => $rh_req_type)
                                        <li>
                                            <a class="effect" href="{{ route('human_resources.request.create', ['type' => $key]) }}">
                                                <i class="fa fa-plus-circle fa-fw"></i>
                                                {{ str_replace(['Solicitud de ', 'Notificación de ', 'Sol. de '], '', $rh_req_type) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>

                    @foreach (session()->get('menus') as $menu)
                        <li>
                            <a href="#">
                                <i class="fa fa-lock fa-fw"></i>
                                {{ $menu->men_descri }}
                                <span class="fa arrow"></span>
                            </a>
                            @if ($menu->submenus->count())
                                <ul class="nav nav-second-level animated zoomInLeft" style="animation-duration: 0.5s;">
                                    @foreach ($menu->submenus as $submenu)
                                        @if (Route::has($submenu->sub_link))
                                            <li>
                                                @if ($submenu->sub_coduni == 'human_resource_request')
                                                    <a class="effect" href="{{ route($submenu->sub_link, ['access' => 'admin']) }}">
                                                        <i class="fa fa-unlock-alt fa-fw"></i>
                                                        {{ $submenu->sub_descri }}
                                                    </a>
                                                @else
                                                    <a class="effect" href="{{ route($submenu->sub_link) }}">
                                                        <i class="fa fa-unlock-alt fa-fw"></i>
                                                        {{ $submenu->sub_descri }}
                                                    </a>
                                                @endif
                                            </li>
                                        @endif
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
