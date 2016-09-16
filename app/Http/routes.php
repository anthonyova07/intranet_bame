<?php
// Route::group(['prefix' => 'intranet'], function () {

Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => 'mercadeo', 'as' => 'mercadeo::'], function () {

    Route::get('/noticia/{id}', 'Mercadeo\MercadeoController@noticia')->name('noticia');
    Route::get('/banner/{id}', 'Mercadeo\MercadeoController@banner')->name('banner');

    Route::get('rompete_el_coco', 'Mercadeo\MercadeoController@coco')->name('coco');

});

Route::get('auth/login', 'Auth\AuthController@getLogin')->name('auth.login');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout')->name('auth.logout');

Route::group(['middleware' => 'auth'], function () {

    Route::group(['prefix' => 'notificaciones', 'as' => 'notificaciones::'], function () {
        Route::get('todas', 'Notificaciones\NotificacionController@getTodas')->name('todas');
        Route::get('notificado/{id}', 'Notificaciones\NotificacionController@getNotificado')->name('notificado');
        Route::get('eliminar/{id}', 'Notificaciones\NotificacionController@getEliminar')->name('eliminar');
    });

    Route::group(['prefix' => 'clientes', 'as' => 'clientes::'], function () {
        Route::get('consulta', 'Clientes\ClienteController@getConsulta')->name('consulta');
        Route::post('consulta', 'Clientes\ClienteController@postConsulta');

        Route::group(['prefix' => 'ncfs', 'as' => 'ncfs::'], function () {
            Route::get('consulta', 'Clientes\Ncfs\NcfController@getConsulta')->name('consulta');
            Route::post('consulta', 'Clientes\Ncfs\NcfController@postConsulta');
            Route::get('anular/{ncf}', 'Clientes\Ncfs\NcfController@getAnular')->name('anular');

            Route::group(['prefix' => 'divisas', 'as' => 'divisas::'], function () {
                Route::get('nuevo', 'Clientes\Ncfs\Divisas\NcfController@getNuevo')->name('nuevo');
                Route::post('nuevo', 'Clientes\Ncfs\Divisas\NcfController@postNuevo');

                Route::get('guardar', 'Clientes\Ncfs\Divisas\NcfController@getGuardar')->name('guardar');

                Route::get('editar/{id}', 'Clientes\Ncfs\Divisas\NcfController@getEditar')->name('editar');
                Route::post('editar/{id}', 'Clientes\Ncfs\Divisas\NcfController@postEditar');

                Route::get('eliminar/todo', 'Clientes\Ncfs\Divisas\NcfController@getEliminarTodo')->name('eliminar_todo');
                Route::get('eliminar/{id}', 'Clientes\Ncfs\Divisas\NcfController@getEliminar')->name('eliminar');
            });

            Route::group(['prefix' => 'no_ibs', 'as' => 'no_ibs::'], function () {
                Route::get('nuevo', 'Clientes\Ncfs\NoIbs\NcfController@getNuevo')->name('nuevo');
                Route::post('nuevo', 'Clientes\Ncfs\NoIbs\NcfController@postNuevo');

                Route::get('guardar', 'Clientes\Ncfs\NoIbs\NcfController@getGuardar')->name('guardar');

                Route::group(['prefix' => 'detalle', 'as' => 'detalle::'], function () {
                    Route::get('nuevo', 'Clientes\Ncfs\NoIbs\NcfController@getNuevoDetalle')->name('nuevo');
                    Route::post('nuevo', 'Clientes\Ncfs\NoIbs\NcfController@postNuevoDetalle');

                    Route::get('editar/{id}', 'Clientes\Ncfs\NoIbs\NcfController@getEditar')->name('editar');
                    Route::post('editar/{id}', 'Clientes\Ncfs\NoIbs\NcfController@postEditar');

                    Route::get('eliminar/{id}', 'Clientes\Ncfs\NoIbs\NcfController@getEliminar')->name('eliminar');
                });

                Route::get('eliminar/todo', 'Clientes\Ncfs\NoIbs\NcfController@getEliminarTodo')->name('eliminar_todo');
            });

            Route::group(['prefix' => 'detalles', 'as' => 'detalles::'], function () {
                Route::get('consulta/{factura}/{es_cliente}', 'Clientes\Ncfs\DetalleController@getConsulta')->name('consulta');
                Route::get('anular/{factura}/{secuencia}', 'Clientes\Ncfs\DetalleController@getAnular')->name('anular');
                Route::get('activar/{factura}/{secuencia}', 'Clientes\Ncfs\DetalleController@getActivar')->name('activar');
                Route::get('imprimir/{factura}/{ibs}', 'Clientes\Ncfs\DetalleController@getImprimir')->name('imprimir');
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

        Route::group(['prefix' => 'logs', 'as' => 'logs::'], function () {
            Route::get('show', 'LogController@getShow')->name('show');
            Route::post('show', 'LogController@postShow');
        });
    });

    Route::group(['prefix' => 'mercadeo', 'as' => 'mercadeo::'], function () {

        Route::group(['prefix' => 'noticias', 'as' => 'noticias::'], function () {

            Route::get('lista', 'Mercadeo\Noticias\NoticiaController@getLista')->name('lista');
            Route::post('lista', 'Mercadeo\Noticias\NoticiaController@postLista');

            Route::get('nueva', 'Mercadeo\Noticias\NoticiaController@getNueva')->name('nueva');
            Route::post('nueva', 'Mercadeo\Noticias\NoticiaController@postNueva');

            Route::get('editar/{id}', 'Mercadeo\Noticias\NoticiaController@getEditar')->name('editar');
            Route::post('editar/{id}', 'Mercadeo\Noticias\NoticiaController@postEditar');

            Route::get('eliminar/{id}/{image}', 'Mercadeo\Noticias\NoticiaController@getEliminar')->name('eliminar');

        });

        Route::group(['prefix' => 'coco', 'as' => 'coco::'], function () {

            Route::get('mantenimiento', 'Mercadeo\Coco\CocoController@getMantenimiento')->name('mantenimiento');
            Route::post('mantenimiento', 'Mercadeo\Coco\CocoController@postMantenimiento');

        });

    });

});

// });
