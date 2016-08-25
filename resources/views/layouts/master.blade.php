<!DOCTYPE html>
<html lang="es">

    @include('partials.head')

    @include('partials.scripts')

    <body ruta="{{ route('home') }}" icon-noti="{{ route('home') . '/images/noFoto.jpg' }}">

        <div id="wrapper">

            @include('partials.navbar')

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12">
                            <h1 class="page-header">@yield('page_title')</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    @include('partials.messages')

                    @yield('contents')
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
        @if (session()->has('usuario'))
            <script>
                verificar_notificaciones();
                setInterval(verificar_notificaciones, {{ env('NOTIFICACIONES_INTERVALO') }});
            </script>
        @endif
    </body>

</html>
