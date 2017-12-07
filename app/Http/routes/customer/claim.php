<?php

Route::group(['prefix' => 'claim'], function () {
    Route::get('destroy', 'Customer\Claim\ClaimController@destroy')->name('customer.claim.destroy');

    Route::get('statuses/{id}', 'Customer\Claim\ClaimController@statuses')->name('customer.claim.statuses');

    Route::resource('{type}/param', 'Customer\Claim\ParamController', ['only' => [
        'create', 'store', 'edit', 'update'
    ]]);

    Route::resource('{claim_id}/{form_type}/form', 'Customer\Claim\ClaimFormController', ['only' => [
        'create', 'store', 'show'
    ]]);

    Route::get('approve/{claim_id}/{to_approve}', 'Customer\Claim\ClaimController@getApprove')->name('customer.claim.approve');
    Route::post('approve/{claim_id}/{to_approve}', 'Customer\Claim\ClaimController@postApprove');

    Route::get('complete/{claim_id}', 'Customer\Claim\ClaimController@getClose')->name('customer.claim.close');
    Route::post('complete/{claim_id}', 'Customer\Claim\ClaimController@postClose');

    Route::get('attach/{claim_id}', 'Customer\Claim\ClaimController@getAttach')->name('customer.claim.attach');
    Route::post('attach/{claim_id}', 'Customer\Claim\ClaimController@postAttach');

    Route::group(['prefix' => 'attach'], function () {
        Route::get('download/{claim_id}/{attach}', 'Customer\Claim\ClaimController@downloadAttach')->name('customer.claim.attach.download');
        Route::delete('delete/{claim_id}/{attach}', 'Customer\Claim\ClaimController@deleteAttach')->name('customer.claim.attach.delete');
    });

    Route::group(['prefix' => 'print'], function () {
        Route::get('claim/{id}', 'Customer\Claim\PrintController@claim')->name('customer.claim.print.claim');
        Route::get('claim/{claim_id}/{form_type}/form/{form_id}', 'Customer\Claim\PrintController@form')->name('customer.claim.print.form');
    });

    Route::group(['prefix' => 'excel'], function () {
        Route::get('claim', 'Customer\Claim\ExcelController@claim')->name('customer.claim.excel.claim');
    });
});

Route::resource('claim', 'Customer\Claim\ClaimController', ['only' => [
    'index', 'create', 'store', 'show'
]]);
