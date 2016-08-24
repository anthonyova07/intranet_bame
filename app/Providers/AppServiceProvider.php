<?php

namespace Bame\Providers;

use Illuminate\Support\ServiceProvider;

use Bame\Models\Notificaciones\Notificacion;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $noti = new Notificacion;
            $view->with('notificaciones', $noti->all());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
