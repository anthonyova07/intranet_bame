<?php

Route::group(['prefix' => 'risk'], function () {
    Route::group(['prefix' => 'event'], function () {
        Route::resource('{type}/param', 'Risk\Event\ParamController', ['only' => [
            'create', 'store', 'edit', 'update'
        ]]);
    });

    Route::resource('event', 'Risk\Event\RiskEventController', ['only' => [
        'index', 'create', 'store', 'show'
    ]]);
});
