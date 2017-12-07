<?php

Route::resource('ncf', 'Customer\Ncf\NcfController', ['only' => [
    'index', 'show', 'destroy'
]]);

Route::group(['prefix' => 'ncf'], function () {
    Route::resource('{invoice}/detail', 'Customer\Ncf\DetailController', ['only' => [
        'index', 'edit', 'update', 'destroy'
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
