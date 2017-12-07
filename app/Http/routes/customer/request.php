<?php

Route::group(['prefix' => 'request', 'namespace' => 'Customer\Requests\Tdc'], function () {

    Route::group(['prefix' => 'tdc'], function () {

        Route::resource('{type}/param', 'ParamController', ['only' => [
            'create', 'store', 'edit', 'update'
        ]]);

        Route::get('print', 'TdcRequestController@print')->name('customer.request.tdc.print');
        Route::post('located/{identification}/{reqnumber?}', 'TdcRequestController@located')->name('customer.request.tdc.located');
        Route::get('excel', 'TdcRequestController@excel')->name('customer.request.tdc.excel');
        Route::post('load', 'TdcRequestController@load')->name('customer.request.tdc.load');
        Route::post('delete/{id}', 'TdcRequestController@delete')->name('customer.request.tdc.delete');
    });

    Route::resource('tdc', 'TdcRequestController', ['only' => [
        'index', 'create', 'store', 'show'
    ]]);
});
