<?php

Route::group(['prefix' => 'risk', 'namespace' => 'Risk\Event'], function () {
    Route::group(['prefix' => 'event'], function () {
        Route::resource('{type}/param', 'ParamController', ['only' => [
            'create', 'store', 'edit', 'update'
        ]]);

        Route::get('mark_event/{risk_event}/{is_event}', 'RiskEventController@mark_event')->name('risk.event.mark_event');

        Route::post('save_evaluation/{risk_event}', 'RiskEventController@save_evaluation')->name('risk.event.save_evaluation');
        Route::post('save_accounting/{risk_event}', 'RiskEventController@save_accounting')->name('risk.event.save_accounting');
    });

    Route::resource('event', 'RiskEventController', ['only' => [
        'index', 'create', 'store', 'show'
    ]]);
});
