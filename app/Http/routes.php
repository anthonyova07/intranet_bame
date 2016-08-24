<?php

Route::get('/', 'HomeController@index')->name('home');

Route::get('/test', function () {
    return 'test';
});

Route::get('auth/login', 'Auth\AuthController@getLogin')->name('auth.login');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout')->name('auth.logout');

Route::group(['middleware' => 'auth'], function () {

    Route::group(['prefix' => 'notificaciones', 'notificaciones::'], function () {
        Route::get('todas', 'Notificaciones\NotificacionController@getTodas')->name('todas');
        Route::get('notificado/{id}', 'Notificaciones\NotificacionController@getNotificado')->name('notificado');
    });

    Route::group(['prefix' => 'operaciones', 'as' => 'operaciones::'], function () {

        Route::group(['prefix' => 'tdc', 'as' => 'tdc::'], function () {
            Route::get('encartes', 'Operaciones\Tdc\EncarteController@getEncartes')->name('encartes');
            Route::post('encartes', 'Operaciones\Tdc\EncarteController@postEncartes');
        });

    });

    Route::group(['prefix' => 'seguridad', 'as' => 'seguridad::'], function () {

        Route::get('accesos', 'Seguridad\AccesoController@getAccesos')->name('accesos');
        Route::post('accesos', 'Seguridad\AccesoController@postAccesos');

        Route::group(['prefix' => 'menus', 'as' => 'menus::'], function () {
            Route::get('lista', 'Seguridad\MenuController@getMenuLista')->name('lista');

            Route::get('nuevo', 'Seguridad\MenuController@getMenuNuevo')->name('nuevo');
            Route::post('nuevo', 'Seguridad\MenuController@postMenuNuevo');

            Route::get('editar/{codigo}', 'Seguridad\MenuController@getMenuEditar')->name('editar')->where(['codigo' => '[0-9]+']);
            Route::post('editar/{codigo}', 'Seguridad\MenuController@postMenuEditar')->where(['codigo' => '[0-9]+']);

            Route::group(['prefix' => '{menu}/submenus', 'as' => 'submenus::'], function () {
                Route::get('lista', 'Seguridad\SubMenuController@getSubMenuLista')->name('lista');

                Route::get('nuevo', 'Seguridad\SubMenuController@getSubMenuNuevo')->name('nuevo');
                Route::post('nuevo', 'Seguridad\SubMenuController@postSubMenuNuevo');

                Route::get('editar/{codigo}', 'Seguridad\SubMenuController@getSubMenuEditar')->name('editar')->where(['codigo' => '[0-9]+']);
                Route::post('editar/{codigo}', 'Seguridad\SubMenuController@postSubMenuEditar')->where(['codigo' => '[0-9]+']);
            });
        });

    });

});
