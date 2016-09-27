<?php

namespace Bame\Providers;

use Illuminate\Support\ServiceProvider;

use Bame\Models\Notification\Notification;

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
            $noti = new Notification;
            $view->with('notifications', $noti->all());
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
