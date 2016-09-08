<?php
// Route::group(['prefix' => 'intranet'], function () {

Route::get('/', 'HomeController@index')->name('home');

Route::get('auth/login', 'Auth\AuthController@getLogin')->name('auth.login');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout')->name('auth.logout');

Route::group(['middleware' => 'auth'], function () {

    Route::group(['prefix' => 'notificaciones', 'notificaciones::'], function () {
        Route::get('todas', 'Notificaciones\NotificacionController@getTodas')->name('todas');
        Route::get('notificado/{id}', 'Notificaciones\NotificacionController@getNotificado')->name('notificado');
        Route::get('eliminar/{id}', 'Notificaciones\NotificacionController@getEliminar')->name('eliminar');
    });

    Route::group(['prefix' => 'clientes', 'as' => 'clientes::'], function () {
        Route::get('consulta', 'Clientes\ClienteController@getConsulta')->name('consulta');
        Route::post('consulta', 'Clientes\ClienteController@postConsulta');

        Route::group(['prefix' => 'ncfs', 'as' => 'ncfs::'], function () {
            Route::get('consulta', 'Clientes\NcfController@getConsulta')->name('consulta');
            Route::post('consulta', 'Clientes\NcfController@postConsulta');
            Route::get('anular/{ncf}', 'Clientes\NcfController@getAnular')->name('anular');

            Route::group(['prefix' => 'divisas', 'as' => 'divisas::'], function () {
                Route::get('nuevo', 'Clientes\NcfController@getNuevo')->name('nuevo');
                Route::post('nuevo', 'Clientes\NcfController@postNuevo');

                Route::get('guardar', 'Clientes\NcfController@getGuardar')->name('guardar');

                Route::get('editar/{id}', 'Clientes\NcfController@getEditar')->name('editar');
                Route::post('editar/{id}', 'Clientes\NcfController@postEditar');

                Route::get('eliminar/todo', 'Clientes\NcfController@getEliminarTodo')->name('eliminar_todo');
                Route::get('eliminar/{id}', 'Clientes\NcfController@getEliminar')->name('eliminar');
            });

            Route::group(['prefix' => 'detalles', 'as' => 'detalles::'], function () {
                Route::get('consulta/{factura}', 'Clientes\NcfDetalleController@getConsulta')->name('consulta');
                Route::get('anular/{factura}/{secuencia}', 'Clientes\NcfDetalleController@getAnular')->name('anular');
                Route::get('activar/{factura}/{secuencia}', 'Clientes\NcfDetalleController@getActivar')->name('activar');
                Route::get('imprimir/{factura}', 'Clientes\NcfDetalleController@getImprimir')->name('imprimir');
            });
        });
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

// });
