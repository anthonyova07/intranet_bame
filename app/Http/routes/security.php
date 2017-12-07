<?php

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
