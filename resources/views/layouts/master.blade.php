<!DOCTYPE html>
<html lang="es">

    @include('layouts.partials.head')

    @include('layouts.partials.scripts')

    <body ruta="{{ route('home') }}" icon-noti="{{ route('home') . '/images/noFoto.jpg' }}">

        <div id="wrapper" style="background-color: #616365;">

            @include('layouts.partials.navbar')

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row row-top">
                        <div class="col-xs-12">
                            {{-- <div class="col-xs-3" style="margin-top: 6px;">
                                <div class="input-group custom-search-form">
                                    <input type="text" class="form-control" placeholder="buscar...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div> --}}
                            <div class="col-xs-12">
                                <h3 class="header-page">@yield('page_title')</h3>
                            </div>
                        </div>
                    </div>

                    @include('layouts.partials.messages')

                    @yield('contents')
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
        <script>
            setTimeout(check_global_notifications, 1500);
        </script>
        @if (session()->has('user'))
            <script>
                setTimeout(check_notifications, 3000);
                setInterval(check_notifications, {{ env('NOTIFICACIONES_INTERVALO') }});
            </script>
        @endif
        <script>
            var time = {{ env('TIMEOUT_LOGOUT', 180000) }};

            var func = function () {
                window.location = '{{ route('auth.logout') }}';
            };

            var timeout = setTimeout(func, time);

            $('body').mousemove(function (e) {
                clearTimeout(timeout);
                timeout = setTimeout(func, time);
            }).keypress(function (e) {
                clearTimeout(timeout);
                timeout = setTimeout(func, time);
            });
        </script>
    </body>

</html>
