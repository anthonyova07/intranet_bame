<?php

Route::get('/', 'HomeController@index')->name('home');

Route::get('rompete_el_coco', 'Marketing\MarketingController@coco')->name('coco');
Route::post('rompete_el_coco', 'Marketing\MarketingController@post_coco');

Route::resource('marketing/show', 'Marketing\MarketingController', ['only' => [
    'show'
]]);

Route::get('auth/login', 'Auth\AuthController@getLogin')->name('auth.login');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout')->name('auth.logout');

Route::group(['middleware' => 'auth'], function () {

    Route::group(['prefix' => 'security'], function () {

        Route::resource('menu', 'Security\MenuController');

        Route::group(['prefix' => 'menu/{menu}'], function ($menu) {
            Route::resource('submenu', 'Security\SubMenuController');
        });

        Route::resource('access', 'Security\AccessController', ['only' => [
            'index', 'store'
        ]]);

        Route::resource('log', 'Security\LogController', ['only' => [
            'index'
        ]]);

    });

    Route::group(['prefix' => 'marketing'], function () {
        Route::resource('news', 'Marketing\News\NewsController');

        Route::resource('break_coco', 'Marketing\Coco\CocoController', ['only' => [
            'index', 'store'
        ]]);
    });

    Route::resource('customer', 'Customer\CustomerController', ['only' => [
        'index'
    ]]);

    Route::group(['prefix' => 'customer'], function () {
        Route::resource('ncf', 'Customer\Ncf\NcfController', ['only' => [
            'index', 'show', 'destroy'
        ]]);

        Route::group(['prefix' => 'ncf'], function () {
            Route::resource('{invoice}/detail', 'Customer\Ncf\DetailController', ['only' => [
                'index', 'destroy'
            ]]);

            Route::resource('no_ibs/new', 'Customer\Ncf\NoIbs\NoIbsController', ['only' => [
                'index', 'store','destroy'
            ]]);

            Route::group(['prefix' => 'no_ibs/new'], function () {
                Route::resource('detail', 'Customer\Ncf\NoIbs\NoIbsDetailController', ['only' => [
                    'create', 'store', 'edit', 'update', 'destroy'
                ]]);
            });

            Route::resource('divisa/new', 'Customer\Ncf\Divisa\DivisaController', ['only' => [
                'index', 'store','destroy'
            ]]);

            Route::group(['prefix' => 'divisa/new'], function () {
                Route::resource('detail', 'Customer\Ncf\Divisa\DivisaDetailController', ['only' => [
                    'edit', 'update', 'destroy'
                ]]);
            });
        });
    });

    Route::group(['prefix' => 'operation'], function () {
        Route::group(['prefix' => 'tdc'], function () {
            Route::resource('receipt', 'Operation\Tdc\Receipt\TdcReceiptController', ['only' => [
                'index', 'store'
            ]]);
        });
    });

    Route::group(['prefix' => 'notification'], function () {
        Route::get('all', 'Notification\NotificationController@all')->name('all');
        Route::get('notified/{id}', 'Notification\NotificationController@notified')->name('notified');
        Route::get('delete/{id}', 'Notification\NotificationController@delete')->name('delete');
    });

});

// DB::listen(function ($query) {
    // var_dump($query->sql);
    // var_dump($query->bindings);
    // $query->time
// });
