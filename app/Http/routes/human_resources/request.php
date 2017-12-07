<?php

Route::group(['prefix' => 'request', 'namespace' => 'HumanResource\Request\\'], function () {
    Route::resource('{type}/param', 'ParamController', ['only' => [
        'create', 'store', 'edit', 'update'
    ]]);

    Route::get('calculate_vac_date_to', 'RequestController@calculate_vac_date_to')->name('human_resources.request.calculate_vac_date_to');
    Route::get('approve/{request_id}/{to_approve}/{type}', 'ApproveController@approve')->name('human_resources.request.approve');
    Route::get('verified/{request_id}/{to_verified}', 'ApproveController@verified')->name('human_resources.request.verified');
    Route::get('changestatus/{request_id}', 'ApproveController@changestatus')->name('human_resources.request.changestatus');
    Route::get('attach/{request_id}/{file_name}', 'RequestController@downloadAttach')->name('human_resources.request.downloadattach');
    Route::post('paid/{request_id}', 'RequestController@paid')->name('human_resources.request.paid');
    Route::post('reintegrate/{request_id}', 'RequestController@reintegrate')->name('human_resources.request.reintegrate');
    Route::post('savevacrhform/{request_id}', 'RequestController@saveVacRHForm')->name('human_resources.request.savevacrhform');
    Route::post('saveantrhform/{request_id}', 'RequestController@saveAntRHForm')->name('human_resources.request.saveantrhform');
    Route::get('cancel/{request_id}', 'RequestController@cancel')->name('human_resources.request.cancel');

    Route::group(['prefix' => 'export'], function () {
        Route::get('excel', 'RequestController@excel')->name('human_resources.request.export.excel');
    });
});

Route::resource('request', 'HumanResource\Request\RequestController', ['only' => [
    'index', 'create', 'store', 'show'
]]);
