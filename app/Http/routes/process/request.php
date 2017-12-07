<?php

Route::group(['prefix' => 'request'], function () {
    Route::resource('{type}/param', 'Process\Request\ParamController', ['only' => [
        'create', 'store', 'edit', 'update'
    ]]);

    Route::post('{process_request}/addusers', 'Process\Request\RequestController@addusers')->name('process.request.addusers');
    Route::get('{process_request}/deleteuser', 'Process\Request\RequestController@deleteuser')->name('process.request.deleteuser');

    Route::get('{process_request}/approval', 'Process\Request\RequestController@approval')->name('process.request.approval');

    Route::post('{process_request}/addstatus', 'Process\Request\RequestController@addstatus')->name('process.request.addstatus');

    Route::post('{process_request}/addattach', 'Process\Request\RequestController@addattach')->name('process.request.addattach');
    Route::get('{process_request}/downloadattach', 'Process\Request\RequestController@downloadattach')->name('process.request.downloadattach');
    Route::delete('{process_request}/deleteattach', 'Process\Request\RequestController@deleteattach')->name('process.request.deleteattach');

    Route::group(['prefix' => 'export'], function () {
        Route::get('status_count_pdf', 'Process\Request\ExportController@status_count_pdf')->name('process.request.export.status_count_pdf');
    });
});

Route::resource('request', 'Process\Request\RequestController', ['only' => [
    'index', 'create', 'store', 'show'
]]);
